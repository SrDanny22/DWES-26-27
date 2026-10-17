<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Autor.php';
require_once __DIR__ . '/../src/Categoria.php';
require_once __DIR__ . '/../src/Libro.php';
require_once __DIR__ . '/../src/datos.php';

// Fase 4: convierte los registros de $datos en objetos Libro.
$libros = [];
foreach ( $datos as $registro) {
    $autor = $registro['autor'] === null ? null : new Autor($registro['autor']);

    $categoria = new Categoria($registro['categoria']);

    $libros[] = new Libro($registro['id'], $registro['titulo'], $registro['paginas'], $autor, $categoria, $registro['disponible']);
}


// Fase 5: realiza aquí las comprobaciones de préstamos e identidad.
$dune = $libros[0];
$otro = $libros[2];

$dune->prestar();
$dune->devolver();
// Añade textos a $mensajes; la vista los mostrará debajo del catálogo.
// Termina devolviendo Dune para conservar el estado inicial del catálogo.
$mensajes = [$dune->ficha(), $libros[3]->ficha(),];

$alias = $dune;

// $alias->prestar();

$mensajes[] = 'Disponible: ' . ($alias === $dune ? 'true' : 'false');



$autorDune = new Autor('Frank Herbert');
$categoriaDune = new Categoria('Ciencia ficción');

$libroDune = new Libro(10, 'Dune', 412, $autorDune, $categoriaDune, true);

$mensajes[] = 'Disponible: ' . ($libroDune === $dune ? 'true' : 'false');

// Lectura del formulario facilitada. La búsqueda conserva el texto escrito.
$entrada = $_GET['q'] ?? '';
$entradaBusqueda = is_string($entrada) ? $entrada : '';
$soloDisponibles = isset($_GET['disponibles']);
$ordenEntrada = $_GET['orden'] ?? 'paginas';
$orden = is_string($ordenEntrada)
    && in_array($ordenEntrada, ['paginas', 'titulo'], true)
    ? $ordenEntrada : 'paginas';

// Fase 6.1: normaliza la búsqueda y filtra con array_filter.

$busqueda = mb_strtolower(trim($entradaBusqueda), 'UTF-8');

$visibles = $libros;

$visibles = array_filter(
    $visibles,
    fn (Libro $libro): bool =>
        ($busqueda === '' || str_contains(mb_strtolower($libro->titulo, 'UTF-8'), $busqueda))
        && (!$soloDisponibles || $libro->disponible)
);



// Fase 6.2: ordena $visibles mediante usort y <=>.
usort(
    $visibles,
    function (Libro $libroA, Libro $libroB) use ($orden): int {
        if ($orden === 'paginas') {
            return $libroA->paginas <=> $libroB->paginas;
        }

        return $libroA->titulo <=> $libroB->titulo;
    } 
);

// Fase 6.3: resumen del catálogo completo, antes de filtrar.
// Completa disponibles con array_filter y paginas con array_reduce.
$resumen = [
    'total' => count($libros),
    'disponibles' => count(array_filter($libros, fn (Libro $libro): bool => $libro->disponible)),
    'paginas' => array_reduce($libros, fn (int $total, Libro $libro): int => $total + $libro->paginas, 0),
];

// Fase 6.3: crea las fichas de los libros visibles con array_map.
$etiquetas = array_map(fn (Libro $libro): string => $libro->ficha(), $visibles);

// Fase 6.3: busca los ids 30 y 999 con array_find y añade mensajes.
$libro30 = array_find($libros, fn (Libro $libro): bool => $libro->id === 30);
$mensajes[] = 'Encontrado: ' . ($libro30?->titulo ?? 'Libro no encontrado');

$libro999 = array_find($libros, fn (Libro $libro): bool => $libro->id === 999);
$mensajes[] = 'Encontrado: ' . ($libro999?->titulo ?? 'Libro no encontrado');

require __DIR__ . '/../vista/catalogo.php';
