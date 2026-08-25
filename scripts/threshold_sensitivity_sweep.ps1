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
        humanObs  = [int]$p[12]
    })
}
$n = $rows.Count
$goodWeather = @("Clear","Mainly Clear","Partly Cloudy")

Write-Host "=== Rain distribution by human_observed class (weather-good subset only) ==="
$subset = $rows | Where-Object { $goodWeather -contains $_.weather }
foreach ($cls in @(0,1)) {
    $g = $subset | Where-Object { $_.humanObs -eq $cls }
    $rainVals = $g | Sort-Object rain | ForEach-Object { $_.rain }
    Write-Host "human_observed=$cls (n=$($g.Count)): rain values = $($rainVals -join ', ')"
}

Write-Host "`n=== Sweep rain threshold (with humidity<=80.5, weather good), maximize F1 on n=$n ==="
$candidates = @(0.05,0.1,0.2,0.3,0.5,1,2,3,5,7,10,15,20)
foreach ($rt in $candidates) {
    $tp=0;$fp=0;$tn=0;$fn=0
    foreach ($r in $rows) {
        $pred = if (($goodWeather -contains $r.weather) -and ($r.humidity -le 80.5) -and ($r.rain -le $rt)) {1} else {0}
        if ($pred -eq 1 -and $r.humanObs -eq 1) { $tp++ }
        elseif ($pred -eq 1 -and $r.humanObs -eq 0) { $fp++ }
        elseif ($pred -eq 0 -and $r.humanObs -eq 0) { $tn++ }
        else { $fn++ }
    }
    $acc = [Math]::Round(100*($tp+$tn)/$n,2)
    $prec = if (($tp+$fp) -gt 0) { [Math]::Round(100*$tp/($tp+$fp),2) } else { 0 }
    $rec = if (($tp+$fn) -gt 0) { [Math]::Round(100*$tp/($tp+$fn),2) } else { 0 }
    $f1 = if (($prec+$rec) -gt 0) { [Math]::Round(2*$prec*$rec/($prec+$rec),2) } else { 0 }
    Write-Host "rain<=$rt : Acc=$acc% Prec=$prec% Rec=$rec% F1=$f1  (TP=$tp FP=$fp TN=$tn FN=$fn)"
}

Write-Host "`n=== Sweep humidity threshold (with rain<=10, weather good) ==="
$humCandidates = @(75,78,80,80.5,82,85,88,90)
foreach ($ht in $humCandidates) {
    $tp=0;$fp=0;$tn=0;$fn=0
    foreach ($r in $rows) {
        $pred = if (($goodWeather -contains $r.weather) -and ($r.humidity -le $ht) -and ($r.rain -le 10)) {1} else {0}
        if ($pred -eq 1 -and $r.humanObs -eq 1) { $tp++ }
        elseif ($pred -eq 1 -and $r.humanObs -eq 0) { $fp++ }
        elseif ($pred -eq 0 -and $r.humanObs -eq 0) { $tn++ }
        else { $fn++ }
    }
    $acc = [Math]::Round(100*($tp+$tn)/$n,2)
    $prec = if (($tp+$fp) -gt 0) { [Math]::Round(100*$tp/($tp+$fp),2) } else { 0 }
    $rec = if (($tp+$fn) -gt 0) { [Math]::Round(100*$tp/($tp+$fn),2) } else { 0 }
    $f1 = if (($prec+$rec) -gt 0) { [Math]::Round(2*$prec*$rec/($prec+$rec),2) } else { 0 }
    Write-Host "humidity<=$ht : Acc=$acc% Prec=$prec% Rec=$rec% F1=$f1  (TP=$tp FP=$fp TN=$tn FN=$fn)"
}
