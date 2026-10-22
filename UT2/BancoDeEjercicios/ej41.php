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

    public function prestar(): void {
        $this->disponible = false;
    }

    public function devolver(): void {
        $this->disponible = true;
    }
}

$objetos = array_map(fn (array $a): Libro => new Libro(
    id: $a['id'],
    titulo: $a['titulo'],
    paginas: $a['paginas'],
    disponible: $a['disponible']
), $datos);

$disponibles = array_filter(
    $objetos,
    fn (Libro $l): bool =>
        $l->disponible
);

$libroId10 = array_find(
    $disponibles,
    fn (Libro $l): bool =>
        $l->id === 10);

if ($libroId10 !== null) {
    $libroId10->prestar();
}

var_dump($objetos);

$disponibles2 = array_filter(
    $objetos,
    fn (Libro $l): bool =>
        $l->disponible
);
echo "<br><br>";
var_dump($disponibles2);