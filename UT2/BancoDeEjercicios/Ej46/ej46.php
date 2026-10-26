<?php

declare(strict_types=1);

require_once __DIR__ . '/Libro.php';
require_once __DIR__ . '/LibroRepository.php';
require_once __DIR__ . '/ArrayLibroRepository.php';
require_once __DIR__ . '/CatalogoDemostracionRepository.php';

// Solo conoce la interfaz, no la implementación concreta
function mostrarCatalogo(LibroRepository $repositorio): void {
    $libros = $repositorio->todos();

    if (count($libros) === 0) {
        echo 'Catálogo vacío<br>';
    }

    foreach ($libros as $libro) {
        echo 'ID: ' . $libro->id() . ' - Titulo: ' . $libro->titulo() . '<br>';
    }

    echo 'Total de libros: ' . count($libros) . '<br><br>';
}

mostrarCatalogo(new CatalogoDemostracionRepository());

mostrarCatalogo(new ArrayLibroRepository([
    new Libro(30, 'Drácula'),
    new Libro(40, 'El Hobbit'),
]));

mostrarCatalogo(new ArrayLibroRepository([]));
