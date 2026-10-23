<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ej43/Libro.php';

$libro1 = new Libro(10, 'Dune', 0);
$libro2 = new Libro(20, 'Solaris', 216);

// $libro1->ficha();

echo '<br>';

// $libro2->ficha();

$libro1->devolver();
// $libro1->ficha();

$libro1->prestar();
$libro1->ficha();
$libro1->prestar();