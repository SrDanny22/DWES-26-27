<?php

$nov1 = [1, 3];
$nov2 = [4, 2, 6];
unset($nov1[0]);

$novedad = array_merge($nov1, $nov2);

sort($novedad);

foreach ($novedad as $nov) {
    echo $nov . "<br>";
}