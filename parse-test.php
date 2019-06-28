<?php
 
// Include Composer autoloader if not already done.
include 'C:/Users/tomas.keresztes/vendor/autoload.php';
 
// Parse pdf file and build necessary objects.

$parser = new \Smalot\PdfParser\Parser();
$pdf    = $parser->parseFile('dokumenty/sazebniky/moneta/1610_sazby.pdf');
//$text = $pdf->getText();

echo $text;
 
?>