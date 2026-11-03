<?php

function e(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$busqueda = '';
$error = '';

if (isset($_GET['q'])) {
    if (is_array($_GET['q'])) {
        $error = 'Entrada no válida.';
    } else {
        $busqueda = trim((string)$_GET['q']);
    }
}

include __DIR__ . '/formulario.phtml';
