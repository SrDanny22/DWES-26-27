<?php

declare(strict_types=1);

namespace App\Service;

use App\Contract\LibroRepository;
use App\Model\Libro;

class CatalogoService {
    public function __construct(private LibroRepository $repositorio) {}

    public function prestarPorId(int $id): void {
        $libro = $this->repositorio->buscarPorId($id);

        if ($libro === null) {
            throw new \InvalidArgumentException('No existe ningún libro con id ' . $id . '.');
        }

        $libro->prestar();
    }

    public function devolverPorId(int $id): void {
        $libro = $this->repositorio->buscarPorId($id);

        if ($libro === null) {
            throw new \InvalidArgumentException('No existe ningún libro con id ' . $id . '.');
        }

        $libro->devolver();
    }

    public function buscarDisponibles(string $texto, int $maximo): array {
        if ($maximo < 1) {
            throw new \InvalidArgumentException('El máximo debe ser al menos 1.');
        }

        $busqueda = mb_strtolower(trim($texto), 'UTF-8');

        // str_contains con búsqueda vacía devuelve true, así se admite cualquier título
        $seleccion = array_filter(
            $this->repositorio->todos(),
            fn (Libro $l): bool => $l->estaDisponible()
                && str_contains(mb_strtolower($l->titulo(), 'UTF-8'), $busqueda)
                && $l->paginas() <= $maximo
        );

        usort(
            $seleccion,
            fn (Libro $a, Libro $b): int => $a->paginas() <=> $b->paginas()
        );

        return $seleccion;
    }
}
