<?php

declare(strict_types=1);

// $contador = 0;
// function incrementar() {
//     $contador++;
// }
// incrementar();
// echo $contador;

// No funciona porque a la funcion habría que pasarle el contador, para poder aumentarlo

function incrementar(int $contador) {
    $contador++;
    echo $contador;
}

incrementar(5);
