<?php

declare(strict_types=1);

class ArrayLibroRepository implements LibroRepository {
    public function __construct(private array $libros) {}

    public function todos(): array {
        return $this->libros;
    }
}
