param(
    [Parameter(Mandatory=$true)][string]$InFile,
    [Parameter(Mandatory=$true)][string]$OutDir
)
Add-Type -AssemblyName System.Drawing

if (-not (Test-Path $OutDir)) { New-Item -ItemType Directory -Path $OutDir -Force | Out-Null }

function DecodeVal($v) {
    if ($null -eq $v) { return "" }
    $v = $v -replace '&#10;', "`n"
    $v = $v -replace '&amp;', '&'
    $v = $v -replace '&lt;', '<'
    $v = $v -replace '&gt;', '>'
    $v = $v -replace '&#8804;', "<="
    $v = $v -replace '&#8805;', ">="
    $v = $v -replace '&#8211;', "-"
    return $v
}

function ParseStyle($style) {
    $d = @{}
    if ($null -eq $style) { return $d }
    foreach ($part in ($style -split ';')) {
        if ($part -match '^([^=]+)=(.*)$') { $d[$matches[1]] = $matches[2] }
        else { $d[$part] = $true }
    }
    return $d
}

function HexColor($hex, $fallback) {
    if ([string]::IsNullOrWhiteSpace($hex) -or $hex -eq 'none') { return $fallback }
    try { return [System.Drawing.ColorTranslator]::FromHtml($hex) } catch { return $fallback }
}

[xml]$xml = Get-Content $InFile -Raw -Encoding UTF8
$diagrams = $xml.mxfile.diagram
if ($null -eq $diagrams) { $diagrams = @() }
if ($diagrams -isnot [System.Array]) { $diagrams = @($diagrams) }

$idx = 0
foreach ($diagram in $diagrams) {
    $idx++
    $model = $diagram.mxGraphModel
    $cells = $model.root.mxCell
    $vertices = @{}
    $edges = @()
    $maxX = 100; $maxY = 100
    foreach ($c in $cells) {
        if ($c.vertex -eq '1' -and $c.mxGeometry) {
            $g = $c.mxGeometry
            $x = [double]$g.x; $y = [double]$g.y; $w = [double]$g.width; $h = [double]$g.height
            $vertices[$c.id] = @{ x=$x; y=$y; w=$w; h=$h; value=(DecodeVal $c.value); style=(ParseStyle $c.style) }
            if (($x+$w) -gt $maxX) { $maxX = $x+$w }
            if (($y+$h) -gt $maxY) { $maxY = $y+$h }
        }
    }
    foreach ($c in $cells) {
        if ($c.edge -eq '1') {
            $edges += @{ source=$c.source; target=$c.target; value=(DecodeVal $c.value); style=(ParseStyle $c.style) }
        }
    }

    $W = [int]($maxX + 60); $H = [int]($maxY + 60)
    $bmp = New-Object System.Drawing.Bitmap $W, $H
    $g = [System.Drawing.Graphics]::FromImage($bmp)
    $g.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::AntiAlias
    $g.TextRenderingHint = [System.Drawing.Text.TextRenderingHint]::AntiAliasGridFit
    $g.Clear([System.Drawing.Color]::White)

    $fontNode = New-Object System.Drawing.Font("Arial", 9)
    $fontTitle = New-Object System.Drawing.Font("Arial", 13, [System.Drawing.FontStyle]::Bold)
    $fontEdge = New-Object System.Drawing.Font("Arial", 8)
    $blackPen = New-Object System.Drawing.Pen([System.Drawing.Color]::Black, 1)
    $sf = New-Object System.Drawing.StringFormat
    $sf.Alignment = [System.Drawing.StringAlignment]::Center
    $sf.LineAlignment = [System.Drawing.StringAlignment]::Center

    function CenterOf($id) {
        if ($vertices.ContainsKey($id)) {
            $v = $vertices[$id]
            return New-Object System.Drawing.PointF(($v.x+$v.w/2), ($v.y+$v.h/2))
        }
        return New-Object System.Drawing.PointF(0,0)
    }
    function EdgePoint($id, $towardPt) {
        $v = $vertices[$id]
        $cx = $v.x+$v.w/2; $cy = $v.y+$v.h/2
        $dx = $towardPt.X - $cx; $dy = $towardPt.Y - $cy
        if ($dx -eq 0 -and $dy -eq 0) { return New-Object System.Drawing.PointF($cx,$cy) }
        $halfW = $v.w/2; $halfH = $v.h/2
        $scaleX = if ($dx -ne 0) { $halfW / [Math]::Abs($dx) } else { [double]::PositiveInfinity }
        $scaleY = if ($dy -ne 0) { $halfH / [Math]::Abs($dy) } else { [double]::PositiveInfinity }
        $scale = [Math]::Min($scaleX, $scaleY)
        return New-Object System.Drawing.PointF(($cx + $dx*$scale), ($cy + $dy*$scale))
    }

    # Draw edges first (behind nodes)
    foreach ($e in $edges) {
        if (-not $vertices.ContainsKey($e.source) -or -not $vertices.ContainsKey($e.target)) { continue }
        $c1 = CenterOf $e.source
        $c2 = CenterOf $e.target
        $p1 = EdgePoint $e.source $c2
        $p2 = EdgePoint $e.target $c1
        $col = HexColor $e.style['strokeColor'] ([System.Drawing.Color]::Black)
        $pen = New-Object System.Drawing.Pen($col, 1.4)
        $pen.EndCap = [System.Drawing.Drawing2D.LineCap]::ArrowAnchor
        if ($e.style['dashed'] -eq '1') { $pen.DashStyle = [System.Drawing.Drawing2D.DashStyle]::Dash }
        $g.DrawLine($pen, $p1, $p2)
        if ($e.value) {
            $mx = ($p1.X+$p2.X)/2; $my = ($p1.Y+$p2.Y)/2
            $g.FillRectangle([System.Drawing.Brushes]::White, ($mx-40), ($my-8), 80, 16)
            $g.DrawString($e.value, $fontEdge, [System.Drawing.Brushes]::Black, (New-Object System.Drawing.RectangleF(($mx-40),($my-8),80,16)), $sf)
        }
    }

    # Draw nodes
    foreach ($id in $vertices.Keys) {
        $v = $vertices[$id]
        $rect = New-Object System.Drawing.RectangleF($v.x, $v.y, $v.w, $v.h)
        $fill = HexColor $v.style['fillColor'] ([System.Drawing.Color]::White)
        $stroke = HexColor $v.style['strokeColor'] ([System.Drawing.Color]::Black)
        $pen2 = New-Object System.Drawing.Pen($stroke, 1.5)
        $brush = New-Object System.Drawing.SolidBrush($fill)

        if ($v.style['shape'] -eq 'rhombus') {
            $pts = @(
                (New-Object System.Drawing.PointF(($v.x+$v.w/2), $v.y)),
                (New-Object System.Drawing.PointF(($v.x+$v.w), ($v.y+$v.h/2))),
                (New-Object System.Drawing.PointF(($v.x+$v.w/2), ($v.y+$v.h))),
                (New-Object System.Drawing.PointF($v.x, ($v.y+$v.h/2)))
            )
            $g.FillPolygon($brush, $pts)
            $g.DrawPolygon($pen2, $pts)
        } elseif ($v.style['text'] -eq $true) {
            # plain text label, no border/fill
        } else {
            $radius = 14
            $path = New-Object System.Drawing.Drawing2D.GraphicsPath
            $d = $radius*2
            $path.AddArc($v.x, $v.y, $d, $d, 180, 90)
            $path.AddArc(($v.x+$v.w-$d), $v.y, $d, $d, 270, 90)
            $path.AddArc(($v.x+$v.w-$d), ($v.y+$v.h-$d), $d, $d, 0, 90)
            $path.AddArc($v.x, ($v.y+$v.h-$d), $d, $d, 90, 90)
            $path.CloseFigure()
            $g.FillPath($brush, $path)
            $g.DrawPath($pen2, $path)
        }

        $useFont = $fontNode
        if ($v.style['fontStyle'] -eq '1' -and $v.style['fontSize']) { $useFont = New-Object System.Drawing.Font("Arial", ([double]$v.style['fontSize']), [System.Drawing.FontStyle]::Bold) }
        elseif ($v.style['text'] -eq $true) { $useFont = $fontTitle }
        elseif ($v.style['fontSize']) { $useFont = New-Object System.Drawing.Font("Arial", ([double]$v.style['fontSize'])) }

        $textRect = New-Object System.Drawing.RectangleF(($v.x+4), ($v.y+2), ($v.w-8), ($v.h-4))
        $localSf = New-Object System.Drawing.StringFormat
        $localSf.Alignment = if ($v.style['align'] -eq 'left') { [System.Drawing.StringAlignment]::Near } else { [System.Drawing.StringAlignment]::Center }
        $localSf.LineAlignment = [System.Drawing.StringAlignment]::Center
        $g.DrawString($v.value, $useFont, [System.Drawing.Brushes]::Black, $textRect, $localSf)
    }

    $g.Dispose()
    $outName = [System.IO.Path]::GetFileNameWithoutExtension($InFile)
    $outFile = Join-Path $OutDir "$outName-$idx.png"
    $bmp.Save($outFile, [System.Drawing.Imaging.ImageFormat]::Png)
    $bmp.Dispose()
    Write-Host "Rendered: $outFile ($W x $H)"
}

