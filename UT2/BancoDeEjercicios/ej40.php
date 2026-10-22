<?php

declare(strict_types=1);

$datos = [
 ['id' => 10, 'titulo' => 'Dune', 'paginas' => 412,
 'disponible' => true],
 ['id' => 20, 'titulo' => 'Drácula', 'paginas' => 418,
 'disponible' => false],
 ['id' => 30, 'titulo' => '1984', 'paginas' => 328,
 'disponible' => true],
 ['id' => 40, 'titulo' => 'It', 'paginas' => 1504,
 'disponible' => true],
];


class Libro {
    public function __construct(public int $id, public string $titulo, public int $paginas, public bool $disponible = true) {}
}

$objetos = array_map(fn (array $a): Libro => new Libro(
    id: $a['id'],
    titulo: $a['titulo'],
    paginas: $a['paginas'],
    disponible: $a['disponible']
), $datos);

usort(
    $objetos,
    fn (Libro $a, Libro $b): int =>
        $a->paginas <=> $b->paginas
    );

$totalPaginas = array_reduce(
    $objetos,
    fn (int $a, Libro $b): int => $a + $b->paginas,
    0
    );

foreach ($objetos as $objeto) {
    echo "Titulo: " . $objeto->titulo . " - Páginas: " . $objeto->paginas . "<br>";
}
echo "Total de paginas: $totalPaginas";

echo "<br><br>Forma descendente<br><br>";

usort(
    $objetos,
    fn (Libro $a, Libro $b): int =>
        $b->paginas <=> $a->paginas
    );

foreach ($objetos as $objeto) {
    echo "Titulo: " . $objeto->titulo . " - Páginas: " . $objeto->paginas . "<br>";
}