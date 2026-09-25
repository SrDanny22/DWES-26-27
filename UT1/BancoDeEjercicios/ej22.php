<?php

declare(strict_types=1);

function esLargo(int $numPaginas): bool {
    return $numPaginas > 500 ? true : false;
}

echo esLargo(144);