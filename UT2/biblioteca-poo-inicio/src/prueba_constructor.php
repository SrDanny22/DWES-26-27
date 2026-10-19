<?php
declare(strict_types=1);

require_once __DIR__ . '/Autor.php';
require_once __DIR__ . '/Categoria.php';
require_once __DIR__ . '/Libro.php';

// Fase 2.1: crea aquí un Autor y una Categoria y muestra sus nombres.

$autor = new Autor('Frank Herbert');
$categoria = new Categoria('Ciencia ficción');

// echo $autor->nombreAutor;
// echo '<br>';
// echo $categoria->nombreCategoria;
// echo '<br>';

// Fase 2.2: cuando completes Libro.php, añade su require_once arriba.
// Después crea los dos libros y muestra su disponibilidad.

// $libro1 = new Libro(10, 'Dune', 412, $autor, $categoria);

// echo $libro1->disponible ? 'true' : 'false';

// echo '<br>';

// $libro2 = new Libro(10, 'Dune', 412, $autor, $categoria, false);

// echo $libro2->disponible ? 'true' : 'false';

// Fase 3.2: sustituye las pruebas anteriores por un Libro construido
$libro = new Libro(10, 'Dune', 412, $autor, $categoria);

echo 'Título: ' . $libro->titulo . '. Páginas: ' . $libro->paginas . '.';
// con las variables $titulo y $paginas. Muestra ambas propiedades.
