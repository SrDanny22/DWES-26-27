<?php

declare(strict_types=1);

// Funcion Java
// static double calcularMulta(int dias, double precioDia) {
//  return dias * precioDia;
// }

function calcularMulta(int $dias, float $precioDia): float {
    return $dias * $precioDia;
}
