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

foreach ($objetos as $objeto) {
    echo 'ID: ' . $objeto->id . '<br>Titulo: ' . $objeto->titulo . '<br>Páginas: ' . $objeto->paginas . '<br><br>';
}

var_dump($datos);