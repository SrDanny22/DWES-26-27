<?php

declare(strict_types=1);

namespace App\Service;

use App\Contract\LibroRepository;
use App\Model\Libro;

class CatalogoService {
    public function __construct(private LibroRepository $repositorio) {}

    public function disponibles(): array {
        return array_filter(
            $this->repositorio->todos(),
            fn (Libro $l): bool => $l->estaDisponible()
        );
    }

    public function titulosDisponibles(): array {
        return array_map(
            fn (Libro $l): string => $l->titulo(),
            $this->disponibles()
        );
    }

    public function prestarPorId(int $id): void {
        $libro = $this->repositorio->buscarPorId($id);

        if ($libro === null) {
            throw new \InvalidArgumentException('No existe ningún libro con id ' . $id . '.');
        }

        $libro->prestar();
    }
}
