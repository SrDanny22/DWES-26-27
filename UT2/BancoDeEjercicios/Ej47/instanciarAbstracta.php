<?php

declare(strict_types=1);

require_once __DIR__ . '/RecursoBiblioteca.php';

// Una clase abstracta no se puede instanciar: PHP lanza Error
$recurso = new RecursoBiblioteca(1, 'Recurso');
