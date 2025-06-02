<?php
require_once _DIR_ . '/../vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml('<h1>¡Hola, Dompdf funciona!</h1>');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("prueba.pdf", array("Attachment" => false));