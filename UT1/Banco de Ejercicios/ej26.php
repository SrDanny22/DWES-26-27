<?php

declare(strict_types=1);

function esLargo(int $numPaginas): bool {
    return $numPaginas > 500 ? true : false;
}

// echo esLargo("600");

// Al usar el declare(strict_types=1), estamos obligando a que si en la funcion declaramos que le pasamos un int, al llamar a la funcion, no podemos pasarle un string "600", tiene que ser un int, si no usasemos el declare(strict_types=1), si nos permitiria usar el "600".