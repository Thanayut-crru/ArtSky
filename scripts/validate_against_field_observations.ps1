$ErrorActionPreference = "Stop"
$path = Join-Path $PSScriptRoot "..\data\human_observed.csv"
$lines = Get-Content $path -Encoding UTF8
$rows = New-Object System.Collections.Generic.List[object]
for ($i = 1; $i -lt $lines.Count; $i++) {
    $p = $lines[$i] -split ','
    if ($p.Count -lt 13) { continue }
    $rows.Add([PSCustomObject]@{
        humidity  = [double]$p[8]
        rain      = [double]$p[9]
        weather   = $p[10]
        sysPred   = [int]$p[11]
        humanObs  = [int]$p[12]
    })
}
$n = $rows.Count
$goodWeather = @("Clear","Mainly Clear","Partly Cloudy")

function EvalRule($predFunc, $label) {
    $tp=0;$fp=0;$tn=0;$fn=0
    foreach ($r in $rows) {
        $pred = & $predFunc $r
        if ($pred -eq 1 -and $r.humanObs -eq 1) { $tp++ }
        elseif ($pred -eq 1 -and $r.humanObs -eq 0) { $fp++ }
        elseif ($pred -eq 0 -and $r.humanObs -eq 0) { $tn++ }
        else { $fn++ }
    }
    Write-Host "$label : TP=$tp FP=$fp TN=$tn FN=$fn"
}

Write-Host "=== Applying the ORIGINAL rule formula directly (humidity<=80, rain<=10, weather good) ==="
EvalRule { param($r) if (($goodWeather -contains $r.weather) -and ($r.humidity -le 80) -and ($r.rain -le 10)) {1} else {0} } "Formula-original"

Write-Host "`n=== Applying the TREE rule formula directly (humidity<=80.5, rain<=0.05, weather good) ==="
EvalRule { param($r) if (($goodWeather -contains $r.weather) -and ($r.humidity -le 80.5) -and ($r.rain -le 0.05)) {1} else {0} } "Formula-tree"

Write-Host "`n=== Using the system_predicted COLUMN as-is ==="
EvalRule { param($r) $r.sysPred } "Column-system_predicted"

Write-Host "`n=== Checking: does system_predicted match the stated original formula? ==="
$mismatch = 0
$mismatchExamples = @()
foreach ($r in $rows) {
    $formulaPred = if (($goodWeather -contains $r.weather) -and ($r.humidity -le 80) -and ($r.rain -le 10)) {1} else {0}
    if ($formulaPred -ne $r.sysPred) {
        $mismatch++
        if ($mismatchExamples.Count -lt 10) { $mismatchExamples += "weather=$($r.weather) humidity=$($r.humidity) rain=$($r.rain) sysPred=$($r.sysPred) formulaPred=$formulaPred" }
    }
}
Write-Host "Mismatches between system_predicted and stated formula: $mismatch / $n"
$mismatchExamples | ForEach-Object { Write-Host "  $_" }

Write-Host "`n=== Are humidity values in this file integers? ==="
$nonInteger = $rows | Where-Object { $_.humidity -ne [Math]::Floor($_.humidity) }
Write-Host "Non-integer humidity count: $($nonInteger.Count) / $n"

Write-Host "`n=== Rain values distribution within weather-good subset ==="
$goodSubset = $rows | Where-Object { $goodWeather -contains $_.weather }
$rainVals = $goodSubset | Group-Object rain | Select-Object Name, Count
$rainVals
