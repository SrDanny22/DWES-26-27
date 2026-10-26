<?php

declare(strict_types=1);

require_once __DIR__ . '/RecursoBiblioteca.php';
require_once __DIR__ . '/Libro.php';
require_once __DIR__ . '/Revista.php';

$recursos = [
    new Libro(10, 'Dune', 412),
    new Revista(20, 'Revista Ciencia', 7),
];

// No se pregunta por la clase concreta, cada objeto responde con su tipo()
foreach ($recursos as $recurso) {
    echo 'ID: ' . $recurso->id() . ' - Titulo: ' . $recurso->titulo() . ' - Tipo: ' . $recurso->tipo() . ' - Origen: ' . $recurso->origen() . '<br>';
}

echo '<br>Fichas<br><br>';

foreach ($recursos as $recurso) {
    echo $recurso->ficha() . '<br>';
}
