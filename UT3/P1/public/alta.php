<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/datos/libros.php';

use Daniel\Biblioteca\Servicio\BibliotecaService;

$bibService = new BibliotecaService($libros);

$valores = [
    'tipo' => '',
    'titulo' => '',
    'autor' => '',
    'paginas' => '',
    'genero' => '',
    'unidades' => '',
    'fechaAlta' => '',
    'destacado' => false,
    'observaciones' => '',
    'correo' => ''
];

$errores = [];

$ficha = null;

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$esPost = $metodo === 'POST';

if ($esPost) {
    foreach ($valores as $clave => $valor) {
        echo $clave . $valor . '<br>';
    }
}

require_once dirname(__DIR__) . '/vistas/alta.php';