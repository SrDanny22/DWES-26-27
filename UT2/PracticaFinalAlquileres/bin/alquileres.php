<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vender/autoload.php';

use Clase\Alquileres\Modelo\{Alquiler, AlquilerBicicleta, AlquilerPatinete, EstadoAlquiler};
use Clase\Alquileres\Servicio\ServicioAlquileres;

$alquileres = [
    new AlquilerBicicleta(501, 'Lucía Torres', 2, EstadoAlquiler::Reservado),
    new AlquilerPatinete(502, 'Alez Ruiz', 2, EstadoAlquiler::Activo),
    new AlquilerBicicleta(503, 'Óscar Gil', 3, EstadoAlquiler::Finalizado),
    new AlquilerPatinete(504, 'Lucía Molina', 1, EstadoAlquiler::Reservado)
];

$servicio = new ServicioAlquileres($alquileres);

function mostrar(
    string $titulo,
    array $alquileres,
    ServicioAlquileres $servicio
): void {
    echo $titulo . PHP_EOL;
    if ($alquileres === []) {
        echo 'Sin resultados' . PHP_EOL;
    }
    foreach ($alquileres as $a) {
        echo $a->id() . ' | ' . $a->cliente() . ' | ' . $a->modalidad()
            . ' | días: ' . $a->dias() . ' | ' . $a->estado()->value
            . ' | ' . $a->importe() . ' céntimos' . PHP_EOL;
    }
    $resumen = $servicio->resumir($alquileres);
    echo 'Cantidad: ' . $resumen['cantidad']
        . ' | Importe: ' . $resumen['importe'] . ' céntimos'
        . PHP_EOL . PHP_EOL;
}
