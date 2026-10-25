<?php

declare(strict_types=1);

// Reparación 2: antes ponía namespace App\Services y no coincidía con la carpeta src/Service
namespace App\Service;

// Reparación 3: sin este use, Libro se interpretaba como App\Service\Libro
use App\Model\Libro;

class CatalogoService {
    public function mostrar(Libro $libro): string {
        return $libro->titulo();
    }
}
