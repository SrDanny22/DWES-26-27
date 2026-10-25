<?php

declare(strict_types=1);

require_once __DIR__ . '/Autor.php';
require_once __DIR__ . '/Categoria.php';
require_once __DIR__ . '/Libro.php';

$libro = new Libro('Dune', new Autor('Frank Herbert', 'AUT-01'), new Categoria('Ciencia ficción'));

// categoria es readonly: no se puede sustituir por otro objeto, PHP lanza Error
$libro->categoria = new Categoria('Narrativa');
