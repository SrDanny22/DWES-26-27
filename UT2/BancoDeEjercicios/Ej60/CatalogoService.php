<?php

declare(strict_types=1);

class CatalogoService {
    public function __construct(private array $libros) {}

    public function titulosDisponiblesHasta(int $maximo): array {
        if ($maximo < 1) {
            throw new InvalidArgumentException('El máximo debe ser al menos 1.');
        }

        $seleccion = array_filter(
            $this->libros,
            fn (Libro $l): bool => $l->estaDisponible() && $l->paginas() <= $maximo
        );

        return array_values(array_map(
            fn (Libro $l): string => $l->titulo(),
            $seleccion
        ));
    }
}
