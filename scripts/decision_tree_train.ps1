$ErrorActionPreference = "Stop"

# ---- Load data ----
$path = Join-Path $PSScriptRoot "..\data\AS_observed.csv"
$lines = Get-Content $path -Encoding UTF8
$rows = New-Object System.Collections.Generic.List[object]
for ($i = 1; $i -lt $lines.Count; $i++) {
    $p = $lines[$i] -split ','
    if ($p.Count -lt 12) { continue }
    $rows.Add([PSCustomObject]@{
        weather  = $p[10]
        humidity = [double]$p[8]
        rain     = [double]$p[9]
        temp     = [double]$p[7]
        label    = [int]$p[-1]
    })
}
Write-Host "Loaded rows: $($rows.Count)"
$total1 = ($rows | Where-Object { $_.label -eq 1 }).Count
Write-Host "Label=1 (Suitable): $total1   Label=0: $($rows.Count - $total1)"

function Gini($n0, $n1) {
    $n = $n0 + $n1
    if ($n -eq 0) { return 0 }
    $p0 = $n0 / $n
    $p1 = $n1 / $n
    return 1 - ($p0 * $p0 + $p1 * $p1)
}

function BestSplit($subset) {
    $n = $subset.Count
    if ($n -eq 0) { return $null }
    $totalN1 = ($subset | Where-Object { $_.label -eq 1 }).Count
    $totalN0 = $n - $totalN1
    $parentGini = Gini $totalN0 $totalN1

    $best = $null
    $bestGain = 0

    # --- Numeric features: humidity, rain, temp ---
    foreach ($feat in @("humidity","rain","temp")) {
        $sorted = $subset | Sort-Object -Property $feat
        $vals = $sorted | ForEach-Object { $_.$feat }
        $labels = $sorted | ForEach-Object { $_.label }
        $leftN0 = 0; $leftN1 = 0
        for ($i = 0; $i -lt $n - 1; $i++) {
            if ($labels[$i] -eq 1) { $leftN1++ } else { $leftN0++ }
            if ($vals[$i] -eq $vals[$i+1]) { continue }  # only split between distinct values
            $leftCount = $i + 1
            $rightCount = $n - $leftCount
            if ($leftCount -lt 20 -or $rightCount -lt 20) { continue }  # min_samples_leaf
            $rightN1 = $totalN1 - $leftN1
            $rightN0 = $totalN0 - $leftN0
            $gLeft = Gini $leftN0 $leftN1
            $gRight = Gini $rightN0 $rightN1
            $weighted = ($leftCount / $n) * $gLeft + ($rightCount / $n) * $gRight
            $gain = $parentGini - $weighted
            if ($gain -gt $bestGain) {
                $threshold = ($vals[$i] + $vals[$i+1]) / 2
                $bestGain = $gain
                $best = @{ type = "numeric"; feature = $feat; threshold = $threshold; gain = $gain }
            }
        }
    }

    # --- Categorical feature: weather ---
    $categories = $subset | Select-Object -ExpandProperty weather -Unique
    foreach ($cat in $categories) {
        $inCat = $subset | Where-Object { $_.weather -eq $cat }
        $outCat = $subset | Where-Object { $_.weather -ne $cat }
        $leftCount = $inCat.Count
        $rightCount = $outCat.Count
        if ($leftCount -lt 20 -or $rightCount -lt 20) { continue }
        $leftN1 = ($inCat | Where-Object { $_.label -eq 1 }).Count
        $leftN0 = $leftCount - $leftN1
        $rightN1 = $totalN1 - $leftN1
        $rightN0 = $totalN0 - $leftN0
        $gLeft = Gini $leftN0 $leftN1
        $gRight = Gini $rightN0 $rightN1
        $weighted = ($leftCount / $n) * $gLeft + ($rightCount / $n) * $gRight
        $gain = $parentGini - $weighted
        if ($gain -gt $bestGain) {
            $bestGain = $gain
            $best = @{ type = "categorical"; feature = "weather"; category = $cat; gain = $gain }
        }
    }

    return $best
}

function BuildTree($subset, $depth, $maxDepth) {
    $n = $subset.Count
    $n1 = ($subset | Where-Object { $_.label -eq 1 }).Count
    $n0 = $n - $n1
    $majority = if ($n1 -ge $n0) { 1 } else { 0 }
    $purity = [Math]::Max($n1, $n0) / [Math]::Max($n,1)

    $node = @{ n = $n; n0 = $n0; n1 = $n1; majority = $majority; purity = $purity }

    if ($depth -ge $maxDepth -or $n -lt 40 -or $purity -ge 0.995) {
        $node.leaf = $true
        return $node
    }

    $split = BestSplit $subset
    if ($null -eq $split) {
        $node.leaf = $true
        return $node
    }

    $node.leaf = $false
    $node.split = $split

    if ($split.type -eq "numeric") {
        $leftSet = $subset | Where-Object { $_.($split.feature) -le $split.threshold }
        $rightSet = $subset | Where-Object { $_.($split.feature) -gt $split.threshold }
    } else {
        $leftSet = $subset | Where-Object { $_.weather -eq $split.category }
        $rightSet = $subset | Where-Object { $_.weather -ne $split.category }
    }

    $node.left = BuildTree $leftSet ($depth + 1) $maxDepth
    $node.right = BuildTree $rightSet ($depth + 1) $maxDepth
    return $node
}

function PrintTree($node, $indent, $branchLabel) {
    $pctSuitable = [Math]::Round(100 * $node.n1 / [Math]::Max($node.n,1), 1)
    if ($node.leaf) {
        $verdict = if ($node.majority -eq 1) { "Suitable" } else { "Not suitable" }
        Write-Host "$indent$branchLabel LEAF -> $verdict  (n=$($node.n), suitable=$($node.n1)/$($node.n)=$pctSuitable%, purity=$([Math]::Round($node.purity*100,1))%)"
    } else {
        $s = $node.split
        if ($s.type -eq "numeric") {
            $desc = "$($s.feature) <= $([Math]::Round($s.threshold,2))"
            $descRight = "$($s.feature) > $([Math]::Round($s.threshold,2))"
        } else {
            $desc = "weather == '$($s.category)'"
            $descRight = "weather != '$($s.category)'"
        }
        Write-Host "$indent$branchLabel [$desc]  (n=$($node.n), suitable%=$pctSuitable, gini_gain=$([Math]::Round($s.gain,4)))"
        PrintTree $node.left ("$indent    ") "IF TRUE ->"
        PrintTree $node.right ("$indent    ") "IF FALSE ($descRight) ->"
    }
}

function Predict($node, $row) {
    if ($node.leaf) { return $node.majority }
    $s = $node.split
    $goLeft = if ($s.type -eq "numeric") { $row.($s.feature) -le $s.threshold } else { $row.weather -eq $s.category }
    if ($goLeft) { return Predict $node.left $row } else { return Predict $node.right $row }
}

Write-Host "`nBuilding tree (max_depth=3, min_samples_leaf=20)...`n"
$tree = BuildTree $rows 0 3
PrintTree $tree "" "ROOT"

# Training accuracy
$correct = 0
foreach ($r in $rows) {
    $pred = Predict $tree $r
    if ($pred -eq $r.label) { $correct++ }
}
$acc = [Math]::Round(100 * $correct / $rows.Count, 2)
Write-Host "`nTraining accuracy: $acc% ($correct / $($rows.Count))"

# Confusion matrix
$tp = ($rows | Where-Object { $_.label -eq 1 -and (Predict $tree $_) -eq 1 }).Count
$fn = ($rows | Where-Object { $_.label -eq 1 -and (Predict $tree $_) -eq 0 }).Count
$fp = ($rows | Where-Object { $_.label -eq 0 -and (Predict $tree $_) -eq 1 }).Count
$tn = ($rows | Where-Object { $_.label -eq 0 -and (Predict $tree $_) -eq 0 }).Count
Write-Host "Confusion matrix: TP=$tp FN=$fn FP=$fp TN=$tn"
$precision = if (($tp+$fp) -gt 0) { [Math]::Round(100*$tp/($tp+$fp),2) } else { 0 }
$recall = if (($tp+$fn) -gt 0) { [Math]::Round(100*$tp/($tp+$fn),2) } else { 0 }
Write-Host "Precision (Suitable): $precision%   Recall (Suitable): $recall%"
