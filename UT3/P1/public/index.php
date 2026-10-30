<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/datos/libros.php';

use Daniel\Biblioteca\Servicio\BibliotecaService;

$bibService = new BibliotecaService($libros);


$q = $_GET['q'] ?? '';

$genero = $_GET['genero'] ?? '';

$tipo = $_GET['tipo'] ?? '';

$soloDestacados = isset($_GET['destacados']);

$librosFiltrados = $bibService->filtrar(
    $q,
    $genero,
    $tipo,
    $soloDestacados
);

$filas = $bibService->filas($librosFiltrados);

$resumen = $bibService->resumen($librosFiltrados);



require_once dirname(__DIR__) . '/vistas/catalogo.php';