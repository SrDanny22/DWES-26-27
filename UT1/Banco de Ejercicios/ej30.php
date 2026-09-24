<?php

declare(strict_types=1);

date_default_timezone_set('Europe/Madrid');

$fechaHoy = new DateTimeImmutable();

$fechaDevolucion = $fechaHoy ->modify('+15 days');

$fechaHoyF = $fechaHoy->format('d/m/Y');
$fechaDevolucionF = $fechaDevolucion->format('d/m/Y');

echo "Fecha actual: $fechaHoyF <br>Fecha devolucion: $fechaDevolucionF";