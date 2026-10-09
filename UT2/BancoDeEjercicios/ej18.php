<?php

declare(strict_types=1);

$cadena = " DRÁCULA ";

$cadena = mb_strtolower(trim($cadena), 'UTF-8');

echo "Cadena: " . $cadena . " - Longitud: " . mb_strlen($cadena, 'UTF-8');
