<?php

function e(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function describir(string|false|null $resultado): string {
    if ($resultado === null) {
        return 'El campo no ha llegado.';
    }

    if ($resultado === false) {
        return 'Correo no válido.';
    }

    return 'Correo válido: ' . $resultado;
}

$correo = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

$_POST['email'] = 'cambiado@example.org';
$repetido = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

// El resultado no cambia al modificar $_POST: filter_input consulta el dato original de la petición.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Variante filter_input</title>
</head>
<body>
    <p>Resultado: <?= e(describir($correo)) ?></p>
    <p>Tras modificar $_POST: <?= e(describir($repetido)) ?></p>
    <p><a href="formulario.php">Volver</a></p>
</body>
</html>
