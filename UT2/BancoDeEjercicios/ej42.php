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

    // public function seleccionarDesdeEntrada(array $libros, mixed $entrada): array {
    //     if(!is_string($entrada)) {
    //         echo 'Entrada no válida<br>';
    //         return [];
    //     }

    //     $esInt = filter_var($entrada, FILTER_VALIDATE_INT);

    //     if ($esInt === false || $esInt < 1) {
    //         echo 'Entrada no válida<br>';
    //         return [];
    //     }

    //     $filtroLibros = array_filter(
    //         $libros,
    //         fn (Libro $l): bool =>
    //             ($l->disponible && $l->paginas < $entrada)
    //     );

    //     $titulos = array_map(
    //         fn (Libro $l): string => 
    //             $l->titulo,
    //         $filtroLibros
    //     );
    //     $libroMasDe400 = array_any(
    //         $filtroLibros,
    //         fn (Libro $l): bool =>
    //             $l->paginas > 400);
    // }

    
}

$objetos = array_map(fn (array $a): Libro => new Libro(
    id: $a['id'],
    titulo: $a['titulo'],
    paginas: $a['paginas'],
    disponible: $a['disponible']
), $datos);

