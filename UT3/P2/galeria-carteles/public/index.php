<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/archivos.php';

$carteles = listarCarteles();
$errorGaleria = null;

if ($carteles === null) {
    $carteles = [];
    $errorGaleria = 'No se ha podido leer la galería de carteles.';
}

require __DIR__ . '/../vistas/galeria.php';
