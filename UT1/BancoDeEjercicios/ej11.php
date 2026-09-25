<?php

$codigo = 'T';

switch($codigo) {
    case 'F':
        $resultado = "Fantasía";
        break;
    case 'CF':
        $resultado = "Ciencia ficción";
        break;
    case 'T':
        $resultado = "Terror";
        break;
    default:
        $resultado = "Desconocido";
        break;
}

echo $resultado;

$resul = match ($codigo) {
    'F' => 'Fantasía',
    'CF' => 'Ciencia ficción',
    'T' => 'Terror',
    default => 'Desconocido'
};

echo "<br>" . $resul;
