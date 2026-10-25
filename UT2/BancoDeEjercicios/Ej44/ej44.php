<?php

declare(strict_types=1);

require_once __DIR__ . '/Autor.php';
require_once __DIR__ . '/Categoria.php';
require_once __DIR__ . '/Libro.php';

$autor = new Autor('Frank Herbert', 'AUT-01');
$categoria = new Categoria('Ciencia ficción');

// Los dos libros comparten el mismo objeto Autor y el mismo objeto Categoria
$libro1 = new Libro('Dune', $autor, $categoria);
$libro2 = new Libro('El mesías de Dune', $autor, $categoria);

echo $libro1->ficha() . '<br>';
echo $libro2->ficha() . '<br>';

$categoria->renombrar('Narrativa');

echo '<br>Después de renombrar la categoría<br><br>';

// Las dos fichas cambian porque apuntan al mismo objeto Categoria
echo $libro1->ficha() . '<br>';
echo $libro2->ficha() . '<br>';
