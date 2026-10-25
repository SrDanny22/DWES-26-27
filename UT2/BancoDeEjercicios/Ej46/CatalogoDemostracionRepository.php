<?php

declare(strict_types=1);

class CatalogoDemostracionRepository implements LibroRepository {
    public function todos(): array {
        return [
            new Libro(10, 'Dune'),
            new Libro(20, 'Solaris'),
        ];
    }
}
