<?php

declare(strict_types=1);

require_once __DIR__ . '/EstadoEjemplar.php';
require_once __DIR__ . '/Ejemplar.php';

$e01 = new Ejemplar('E-01');

$e01->prestar();
echo $e01->codigo() . ': ' . $e01->estado()->value . '<br>';

$e01->devolver();
echo $e01->codigo() . ': ' . $e01->estado()->value . '<br>';

$e01->prestar();
echo $e01->codigo() . ': ' . $e01->estado()->value . '<br>';

$e01->marcarPerdido();
echo $e01->codigo() . ': ' . $e01->estado()->value . '<br>';

echo '<br>';

try {
    $e01->devolver();
} catch (LogicException $e) {
    echo $e->getMessage() . '<br>';
}

$e02 = new Ejemplar('E-02');

try {
    $e02->devolver();
} catch (LogicException $e) {
    echo $e->getMessage() . '<br>';
}

echo '<br>Estados finales<br><br>';

echo $e01->codigo() . ': ' . $e01->estado()->value . '<br>';
echo $e02->codigo() . ': ' . $e02->estado()->value . '<br>';
