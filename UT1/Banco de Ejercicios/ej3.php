<?php

$precio = 24.90;

$precioDescontado = $precio;

$precioDescontado *= 0.85;

$iva = $precioDescontado * 0.04;

$precioFinal = $precioDescontado + $iva;

echo "Precio descontado: $precioDescontado €<br>";
echo "IVA: $iva €<br>";
echo "Precio final: $precioFinal €";


