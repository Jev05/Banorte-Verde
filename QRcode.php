<?php
$texto = "https://banorteverde.mx";
echo "<h2>Código QR</h2>";
echo "<img src='https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=" . urlencode($texto) . "'>";
?>
