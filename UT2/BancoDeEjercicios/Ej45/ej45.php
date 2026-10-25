<?php

declare(strict_types=1);

require_once __DIR__ . '/EstadoEjemplar.php';
require_once __DIR__ . '/Ejemplar.php';

$ejemplares = [
    new Ejemplar('E-01'),
    new Ejemplar('E-02', EstadoEjemplar::Prestado),
    new Ejemplar('E-03', EstadoEjemplar::Perdido),
];

foreach ($ejemplares as $ejemplar) {
    echo 'Código: ' . $ejemplar->codigo() . ' - Name: ' . $ejemplar->estado()->name . ' - Value: ' . $ejemplar->estado()->value . '<br>';
}

echo '<br>Disponibles<br><br>';

$disponibles = array_filter(
    $ejemplares,
    fn (Ejemplar $e): bool => $e->estado() === EstadoEjemplar::Disponible
);

foreach ($disponibles as $ejemplar) {
    echo $ejemplar->codigo() . '<br>';
}

echo '<br>Cambios de estado de E-01<br><br>';

$e01 = $ejemplares[0];
$entradas = ['prestado', 'perdido', 'reservado'];

foreach ($entradas as $entrada) {
    $estado = EstadoEjemplar::tryFrom($entrada);

    if ($estado === null) {
        echo 'Entrada ' . $entrada . ': Estado no válido<br>';
    } else {
        $e01->cambiarEstado($estado);
    }

    echo 'Estado actual de ' . $e01->codigo() . ': ' . $e01->estado()->value . '<br>';
}

echo '<br>Valores admitidos<br><br>';

foreach (EstadoEjemplar::cases() as $caso) {
    echo $caso->value . '<br>';
}

echo '<br>Ejemplares por estado<br><br>';

foreach (EstadoEjemplar::cases() as $caso) {
    $cantidad = count(array_filter(
        $ejemplares,
        fn (Ejemplar $e): bool => $e->estado() === $caso
    ));
    echo $caso->value . ': ' . $cantidad . '<br>';
}
