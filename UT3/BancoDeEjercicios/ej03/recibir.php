<?php

$titulo = '';

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$esPost = $metodo === 'POST';

if ($esPost) {
    $entrada = $_POST['titulo'] ?? '';
    if (!is_string($entrada)) {
        $entrada = '';
    }
    $titulo = trim($entrada);
}