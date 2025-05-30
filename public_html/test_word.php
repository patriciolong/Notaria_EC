<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

$phpWord = new PhpWord();
$section = $phpWord->addSection();
$section->addText('Hola Mundo!');

$filename = 'test.docx';
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$objWriter = IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('php://output');
exit;
?>