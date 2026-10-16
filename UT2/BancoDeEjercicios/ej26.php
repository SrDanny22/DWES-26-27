<?php

declare(strict_types=1);

function mostrar(mixed $valor): string {
    if (is_bool($valor)) {
        return $valor ? 'true' : 'false';
    }

    return (string) $valor;
}

echo mostrar(true);
echo "<br>";
echo mostrar(42);
echo "<br>";
echo mostrar('Dune');

// mixed debe ser el último recurso y no un sustituto de la precisión en el tipado.