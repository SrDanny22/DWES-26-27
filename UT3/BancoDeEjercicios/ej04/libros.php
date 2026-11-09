<?php

function e(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$busqueda = '';
$error = '';

$entrada = $_GET['q'] ?? '';

if (is_string($entrada)) {
    $busqueda = trim($entrada);
} else {
    $error = 'Entrada no válida.';
}

include __DIR__ . '/formulario.php';
