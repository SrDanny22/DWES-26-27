<?php

declare(strict_types=1);

namespace App\Model;

class Revista extends Recurso {
    public function tipo(): string {
        return 'revista';
    }
}
