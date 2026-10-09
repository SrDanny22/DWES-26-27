<?php

declare(strict_types=1);

$codigo = "LIB-2026-0042";

$codigoValido = preg_match(
    '/^LIB-\d{4}-\d{4}$/',
    $codigo
);

var_dump($codigoValido);
