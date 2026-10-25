<?php

declare(strict_types=1);

namespace App\Model;

class Libro extends Recurso {
    public function tipo(): string {
        return 'libro';
    }
}
