<?php

function duplicarValor(int $n) {
 $n *= 2;
}

function duplicarReferencia(int &$n) {
 $n *= 2;
}

$a = 5;
$b = 5;
duplicarValor($a);
duplicarReferencia($b);
echo "$a - $b";

// La salida será 5 - 10 porque al usar la primera función en a, la informacion no se guarda en la variable, habria que crear otra variable para tener el valor, en cambio, en la segunda función, la función usa & que significa que la información apunta hacia la misma variable que le pasamos y no sera necesario crear otra variable para guardar la información.