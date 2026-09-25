<?php

declare(strict_types=1);

date_default_timezone_set('Europe/Madrid');

$fecha1 = new DateTimeImmutable('2026-09-01');
$fecha2 = new DateTimeImmutable('2026-09-18');

$diferencia = $fecha1->diff($fecha2);

echo "Días de diferencia entre las fechas: $diferencia->days";