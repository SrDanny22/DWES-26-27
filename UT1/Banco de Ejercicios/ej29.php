<?php

declare(strict_types=1);

date_default_timezone_set('Europe/Madrid');

$timestamp = time();

echo "Timestamp actual: $timestamp <br>";

$fechaActual = date('d/m/Y - H:i', $timestamp);

echo "Fecha actual: $fechaActual";