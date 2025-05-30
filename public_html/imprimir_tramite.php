<?php
session_start();
// Habilitar errores para depuración (cambiar a 0 para producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_error_tramite.log'); // Un log diferente para este archivo

// Incluir la librería de PHPWord
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
// No necesitamos SimpleType\VerticalPosition para este documento por ahora, pero lo dejo por si acaso
// use PhpOffice\PhpWord\SimpleType\VerticalPosition;

// Incluir tu archivo de conexión a la base de datos
include("conexionbd.php");

// Verificar si se ha pasado el ID del trámite
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID de trámite no proporcionado o inválido.";
    exit;
}

$id_tramite = (int)$_GET['id']; // Castear a entero para seguridad

// Consulta para obtener los datos del trámite, cliente y usuario
$sql = "SELECT tv.*, c.*, u.u_nombre, u.u_apellido
        FROM tramites_varios tv
        JOIN cliente c ON tv.id_cliente = c.id_cliente
        JOIN usuario u ON tv.id_usuario = u.id_usuario
        WHERE tv.id_tramite_varios = ?";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    error_log("Error al preparar la consulta SQL en imprimir_tramite.php: " . $conexion->error);
    echo "Error interno al procesar la solicitud para el trámite.";
    exit;
}

$stmt->bind_param("i", $id_tramite);
$stmt->execute();
$result = $stmt->get_result();
$tramite = $result->fetch_assoc();
$stmt->close();

if (!$tramite) {
    echo "Trámite no encontrado con el ID: " . htmlspecialchars($id_tramite) . ".";
    exit;
}

// Inicializar PhpWord
$phpWord = new PhpWord();

// Definir estilos
$phpWord->addFontStyle('TitleStyle', ['name' => 'Times New Roman', 'size' => 16, 'bold' => true]);
$phpWord->addFontStyle('SubtitleStyle', ['name' => 'Times New Roman', 'size' => 12, 'bold' => true]);
$phpWord->addFontStyle('NormalStyle', ['name' => 'Times New Roman', 'size' => 11]);
$phpWord->addParagraphStyle('Center', ['align' => 'center']);
$phpWord->addParagraphStyle('Left', ['align' => 'left']);
$phpWord->addParagraphStyle('Justify', ['align' => 'both']);
$phpWord->addParagraphStyle('Right', ['align' => 'right']); // Añadir estilo para la derecha

// Añadir una sección al documento
$section = $phpWord->addSection();

// --- Limpiar y obtener variables para el documento ---
// Puedes seguir usando trim() para limpiar espacios al inicio/final
$c_nombre = trim($tramite['c_nombre'] ?? '');
$c_apellido = trim($tramite['c_apellido'] ?? '');
$c_identificacion = trim($tramite['c_identificacion'] ?? '');
$c_telefono = trim($tramite['c_telefono'] ?? '');
$c_direccion = trim($tramite['c_direccion'] ?? '');
$c_email = trim($tramite['c_email'] ?? '');
$c_ciudad = trim($tramite['c_ciudad'] ?? '');

$tv_fecha = date('d/m/Y', strtotime($tramite['tv_fecha'] ?? date('Y-m-d'))); // Asegura formato fecha
$tv_ntramite = trim($tramite['tv_ntramite'] ?? '');
$tv_valor_tramite = number_format($tramite['tv_valor_tramite'] ?? 0, 2, '.', ',');
$c_abonado = number_format($tramite['c_abonado'] ?? 0, 2, '.', ',');
$c_saldo = number_format($tramite['c_saldo'] ?? 0, 2, '.', ',');
$tv_nrecibo = trim($tramite['tv_nrecibo'] ?? '');
$u_nombre = trim($tramite['u_nombre'] ?? '');
$u_apellido = trim($tramite['u_apellido'] ?? '');

// Mapear los servicios para mostrar "Sí" o "No"
$traducciones = ($tramite['tv_traducciones'] ?? 0) ? 'Sí' : 'No';
$apostillas = ($tramite['tv_apostillas'] ?? 0) ? 'Sí' : 'No';
$autenticaciones = ($tramite['tv_autenticaciones'] ?? 0) ? 'Sí' : 'No';
$legalizaciones = ($tramite['tv_legalizaciones'] ?? 0) ? 'Sí' : 'No';
$asesoramiento = ($tramite['tv_asesoramiento'] ?? 0) ? 'Sí' : 'No';
$otro = ($tramite['tv_otro'] ?? 0) ? 'Sí' : 'No';
$observaciones = trim($tramite['tv_observaciones'] ?? '');


// --- Contenido del documento Word ---

// Encabezado
$section->addText('NOTARÍA PÚBLICA DEL CANTÓN CUENCA', 'TitleStyle', 'Center');
$section->addTextBreak(1);

// Información del Trámite
$section->addText('COMPROBANTE DE TRÁMITE', 'SubtitleStyle', 'Center');
$section->addTextBreak(1);

$section->addText('FECHA: ' . $tv_fecha, 'NormalStyle', 'Right');
$section->addText('Nº TRÁMITE: ' . $tv_ntramite, 'NormalStyle', 'Right');
$section->addTextBreak(1);

$section->addText('DATOS DEL CLIENTE', 'SubtitleStyle', 'Left');
$section->addTextBreak(1);

$section->addText('Nombre: ' . $c_nombre . ' ' . $c_apellido, 'NormalStyle', 'Left');
$section->addText('Identificación: ' . $c_identificacion, 'NormalStyle', 'Left');
$section->addText('Teléfono: ' . $c_telefono, 'NormalStyle', 'Left');
$section->addText('Dirección: ' . $c_direccion, 'NormalStyle', 'Left');
$section->addText('Ciudad: ' . $c_ciudad, 'NormalStyle', 'Left');
$section->addText('Email: ' . $c_email, 'NormalStyle', 'Left');
$section->addTextBreak(1);

$section->addText('SERVICIOS SOLICITADOS', 'SubtitleStyle', 'Left');
$section->addTextBreak(1);

$section->addListItem('Traducciones: ' . $traducciones, 0, 'NormalStyle', 'Left');
$section->addListItem('Apostillas: ' . $apostillas, 0, 'NormalStyle', 'Left');
$section->addListItem('Autenticaciones: ' . $autenticaciones, 0, 'NormalStyle', 'Left');
$section->addListItem('Legalizaciones: ' . $legalizaciones, 0, 'NormalStyle', 'Left');
$section->addListItem('Asesoramiento: ' . $asesoramiento, 0, 'NormalStyle', 'Left');
$section->addListItem('Otro: ' . $otro, 0, 'NormalStyle', 'Left');
$section->addTextBreak(1);

$section->addText('Observaciones:', 'SubtitleStyle', 'Left');
$section->addText($observaciones, 'NormalStyle', 'Justify');
$section->addTextBreak(1);

$section->addText('VALOR DEL TRÁMITE: $' . $tv_valor_tramite, 'NormalStyle', 'Left');
$section->addText('ABONO: $' . $c_abonado, 'NormalStyle', 'Left');
$section->addText('SALDO: $' . $c_saldo, 'NormalStyle', 'Left');
$section->addText('RECIBO Nº: ' . $tv_nrecibo, 'NormalStyle', 'Left');
$section->addTextBreak(2);

$section->addText('Hemos solicitado los servicios de Notaría Ecuador Inc. Para la(s)', 'NormalStyle', 'Justify');
$section->addText('Traducción(es) y apostille(s) de(los) documentos arriba mencionados.', 'NormalStyle', 'Justify');
$section->addTextBreak(1);
$section->addText('PARA USO INTERNO DE LA OFICINA', 'SubtitleStyle', 'Center');
$section->addTextBreak(1);

$section->addText('FIRMA: _________________________________', 'NormalStyle', 'Center');
$section->addText('Registrado por: ' . $u_nombre . ' ' . $u_apellido, 'NormalStyle', 'Center');
$section->addTextBreak(2);


// --- Preparar el nombre del archivo para la descarga ---
$filename = 'Comprobante_Tramite_' . str_replace('/', '-', $tv_ntramite) . '_' . str_replace(' ', '_', $c_apellido) . '.docx';

// --- Cabeceras HTTP para forzar la descarga del archivo Word ---
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');

// --- Generar y guardar el documento en la salida ---
$objWriter = IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('php://output');

// --- Finalizar el script ---
exit;

?>