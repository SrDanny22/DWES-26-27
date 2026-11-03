<?php

function e(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$entrada = $_POST['email'] ?? '';

if (!is_string($entrada)) {
    $mensaje = 'El correo debe ser texto.';
} else {
    $texto = trim($entrada);
    $correo = filter_var($texto, FILTER_VALIDATE_EMAIL);
    $mensaje = $correo === false ? 'Correo no válido.' : 'Correo válido: ' . $correo;
}

// Comparación: "lector@example.org" es válido en las dos y "lector@" en ninguna.
// " lector@example.org " solo es válido aquí, porque se recorta antes de validar; filter_input valida el dato original.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Variante filter_var</title>
</head>
<body>
    <p>Resultado: <?= e($mensaje) ?></p>
    <p><a href="formulario.php">Volver</a></p>
</body>
</html>
