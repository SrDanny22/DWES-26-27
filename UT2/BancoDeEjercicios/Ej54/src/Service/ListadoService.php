<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Recurso;

class ListadoService {
    public function lineas(array $recursos): array {
        return array_map(
            fn (Recurso $r): string => $r->tipo() . ': ' . $r->titulo(),
            $recursos
        );
    }
}
