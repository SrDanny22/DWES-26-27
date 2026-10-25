<?php

declare(strict_types=1);

require_once __DIR__ . '/RecursoBiblioteca.php';

// origen() es final: PHP da un error fatal al intentar sobrescribirlo
class Folleto extends RecursoBiblioteca {
    public function tipo(): string {
        return 'folleto';
    }

    public function origen(): string {
        return 'Otro sitio';
    }
}
