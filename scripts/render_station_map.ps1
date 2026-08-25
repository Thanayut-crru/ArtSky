$ErrorActionPreference = "Stop"
Add-Type -AssemblyName System.Drawing

$boundaryPath = Join-Path $PSScriptRoot "..\data\chiangrai_boundary.json"
$data = Get-Content $boundaryPath -Raw | ConvertFrom-Json
$ring = $data[0].geojson.coordinates[0]   # array of [lon,lat]

$stations = @(
    @{ name="Phu Chi Fa";  lat=19.851383; lon=100.453975; sensor=$true }
    @{ name="Phu Chi Duen"; lat=19.882131; lon=100.500142; sensor=$true }
    @{ name="Phu Chi Dao"; lat=19.869002; lon=100.486419; sensor=$true }
    @{ name="CRRU Observatory"; lat=19.992071; lon=99.844441; sensor=$false }
    @{ name="Mae Fah Luang Garden (Doi Tung)"; lat=20.326110; lon=99.813845; sensor=$false }
    @{ name="Hom Lom Joy"; lat=19.705495; lon=99.760664; sensor=$false }
    @{ name="Doi Sa-ngo"; lat=20.346547; lon=99.987530; sensor=$false }
    @{ name="Sri Kham, Mae Chan"; lat=20.220655; lon=99.827766; sensor=$false }
    @{ name="Kaeo Kang Na Farmstay"; lat=20.364135; lon=99.886741; sensor=$false }
    @{ name="CR PAO Learning Center"; lat=19.928346; lon=99.859843; sensor=$false }
    @{ name="Ban Pang Luang"; lat=19.488732; lon=99.588826; sensor=$false }
)

# Bounding box: union of boundary ring and stations, with margin
$allLons = @($ring | ForEach-Object { $_[0] }) + @($stations | ForEach-Object { $_.lon })
$allLats = @($ring | ForEach-Object { $_[1] }) + @($stations | ForEach-Object { $_.lat })
$minLon = ($allLons | Measure-Object -Minimum).Minimum
$maxLon = ($allLons | Measure-Object -Maximum).Maximum
$minLat = ($allLats | Measure-Object -Minimum).Minimum
$maxLat = ($allLats | Measure-Object -Maximum).Maximum
$marginLon = ($maxLon - $minLon) * 0.08
$marginLat = ($maxLat - $minLat) * 0.08
$minLon -= $marginLon; $maxLon += $marginLon
$minLat -= $marginLat; $maxLat += $marginLat

$W = 1000; $H = 1050
$plotW = 900; $plotH = 950; $offX = 60; $offY = 30

$latMid = ($minLat + $maxLat) / 2
$lonScaleCorrection = [Math]::Cos($latMid * [Math]::PI / 180)  # correct for longitude compression

function ToPx($lon, $lat) {
    $x = $offX + (($lon - $minLon) * $lonScaleCorrection) / (($maxLon - $minLon) * $lonScaleCorrection) * $plotW
    $y = $offY + (1 - (($lat - $minLat) / ($maxLat - $minLat))) * $plotH
    return New-Object System.Drawing.PointF($x, $y)
}

$bmp = New-Object System.Drawing.Bitmap $W, $H
$g = [System.Drawing.Graphics]::FromImage($bmp)
$g.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::AntiAlias
$g.TextRenderingHint = [System.Drawing.Text.TextRenderingHint]::AntiAliasGridFit
$g.Clear([System.Drawing.Color]::White)

# Draw boundary polygon
$pts = New-Object System.Collections.Generic.List[System.Drawing.PointF]
foreach ($c in $ring) { $pts.Add((ToPx $c[0] $c[1])) }
$fillBrush = New-Object System.Drawing.SolidBrush([System.Drawing.Color]::FromArgb(255, 235, 245, 230))
$borderPen = New-Object System.Drawing.Pen([System.Drawing.Color]::FromArgb(255, 90, 130, 90), 2)
$g.FillPolygon($fillBrush, $pts.ToArray())
$g.DrawPolygon($borderPen, $pts.ToArray())

# Draw stations
$fontLabel = New-Object System.Drawing.Font("Arial", 10, [System.Drawing.FontStyle]::Bold)
$sensorBrush = New-Object System.Drawing.SolidBrush([System.Drawing.Color]::FromArgb(255, 40, 90, 200))
$apiBrush = New-Object System.Drawing.SolidBrush([System.Drawing.Color]::FromArgb(255, 220, 130, 30))
$whitePen = New-Object System.Drawing.Pen([System.Drawing.Color]::White, 1.5)

foreach ($s in $stations) {
    $p = ToPx $s.lon $s.lat
    $brush = if ($s.sensor) { $sensorBrush } else { $apiBrush }
    $r = 9
    $g.FillEllipse($brush, ($p.X-$r), ($p.Y-$r), $r*2, $r*2)
    $g.DrawEllipse($whitePen, ($p.X-$r), ($p.Y-$r), $r*2, $r*2)
    $labelRect = New-Object System.Drawing.RectangleF(($p.X+10), ($p.Y-8), 220, 18)
    $g.FillRectangle([System.Drawing.Brushes]::White, $labelRect.X, $labelRect.Y, 2, 2)  # no-op keep
    $g.DrawString($s.name, $fontLabel, [System.Drawing.Brushes]::Black, $labelRect)
}

# Legend
$legFont = New-Object System.Drawing.Font("Arial", 11)
$ly = $H - 55
$g.FillEllipse($sensorBrush, 60, $ly, 16, 16)
$g.DrawString("Sensor-equipped station (AS-System, n=3)", $legFont, [System.Drawing.Brushes]::Black, 84, ($ly-2))
$g.FillEllipse($apiBrush, 60, ($ly+25), 16, 16)
$g.DrawString("API-only station (n=8)", $legFont, [System.Drawing.Brushes]::Black, 84, ($ly+23))

$captionFont = New-Object System.Drawing.Font("Arial", 9, [System.Drawing.FontStyle]::Italic)
$g.DrawString("Province boundary source: OpenStreetMap / Nominatim (administrative boundary, retrieved programmatically).", $captionFont, [System.Drawing.Brushes]::Gray, 500, ($H-40))

$g.Dispose()
$outDir = Join-Path $PSScriptRoot "..\output"
if (-not (Test-Path $outDir)) { New-Item -ItemType Directory -Path $outDir -Force | Out-Null }
$outFile = Join-Path $outDir "station_map.png"
$bmp.Save($outFile, [System.Drawing.Imaging.ImageFormat]::Png)
$bmp.Dispose()
Write-Host "Saved: $outFile"
