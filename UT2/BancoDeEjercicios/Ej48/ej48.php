<?php

declare(strict_types=1);

require_once __DIR__ . '/TieneFechaCreacion.php';
require_once __DIR__ . '/Libro.php';
require_once __DIR__ . '/Socio.php';

$libro1 = new Libro('Dune', '2026-10-01');
$libro2 = new Libro('Solaris', '2026-10-02');
$socia = new Socio('Ana', '2026-10-03');

echo 'Libro: ' . $libro1->titulo() . ' - Fecha: ' . $libro1->fechaCreacion() . '<br>';
echo 'Libro: ' . $libro2->titulo() . ' - Fecha: ' . $libro2->fechaCreacion() . '<br>';
echo 'Socia: ' . $socia->nombre() . ' - Fecha: ' . $socia->fechaCreacion() . '<br>';

echo '<br>Etiquetas<br><br>';

echo $libro1->etiquetaCreacion() . '<br>';
echo $libro2->etiquetaCreacion() . '<br>';
echo $socia->etiquetaCreacion() . '<br>';
