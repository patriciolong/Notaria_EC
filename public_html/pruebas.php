<!-- formulario_divorcio.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Divorcio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Registro de Trámite de Divorcio</h2>
    <form action="controlador_divorcio.php" method="POST" class="border p-4 bg-white rounded shadow-sm">

        <!-- Tipo de divorcio -->
        <div class="mb-3">
            <label class="form-label">Tipo de divorcio</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="controvertido" value="1">
                <label class="form-check-label">Controvertido</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="consensual" value="1">
                <label class="form-check-label">Consensual</label>
            </div>
        </div>

        <!-- Datos del cónyuge -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nombre del cónyuge</label>
                <input type="text" name="nombre_conyuge" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Identificación del cónyuge</label>
                <input type="text" name="identificacion_conyuge" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección del cónyuge</label>
            <input type="text" name="direccion_conyuge" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Apartamento</label>
                <input type="text" name="apartamento_conyuge" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Ciudad</label>
                <input type="text" name="ciudad_conyuge" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Estado</label>
                <input type="text" name="estado_conyuge" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Código Postal</label>
                <input type="text" name="postal_conyuge" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono_conyuge" class="form-control" required>
            </div>
        </div>

        <!-- Datos del matrimonio -->
        <div class="mb-3">
            <label class="form-label">Lugar de matrimonio</label>
            <input type="text" name="lugar_matrimonio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de matrimonio</label>
            <input type="date" name="fecha_matrimonio" class="form-control" required>
        </div>

        <!-- Estado de separación -->
        <div class="mb-3">
            <label class="form-label">¿Está separado de su cónyuge?</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="separado" value="1">
                <label class="form-check-label">Sí</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="no_separado" value="1">
                <label class="form-check-label">No</label>
            </div>
        </div>

        <!-- Documentos -->
        <div class="mb-3">
            <label class="form-label">Documentos que posee</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="partida_matrimonio" value="1">
                <label class="form-check-label">Partida de matrimonio</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="partida_nacimiento" value="1">
                <label class="form-check-label">Partida de nacimiento de menores</label>
            </div>
        </div>

        <!-- Contacto en Ecuador -->
        <div class="mb-3">
            <label class="form-label">Contacto en el Ecuador</label>
            <input type="text" name="contacto_ecuador" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono del contacto</label>
            <input type="text" name="telefono_contacto" class="form-control">
        </div>

        <!-- Observaciones -->
        <div class="mb-3">
            <label class="form-label">Observaciones</label>
            <textarea name="observaciones" class="form-control" rows="3"></textarea>
        </div>

        <!-- Honorarios y abono -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Honorarios</label>
                <input type="number" step="0.01" name="honorarios" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Abono</label>
                <input type="number" step="0.01" name="abono" class="form-control" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Registrar trámite</button>
    </form>
</div>

</body>
</html>
