<?php

$libro = [
    "id" => 01,
    "titulo" => "Konosuba",
    "autor" => "Natsume Akatsuki",
    "paginas" => 415,
    "disponible" => true
];

$libro["disponible"] = false;

foreach ($libro as $clave => $valor) {
    echo "$clave: $valor<br>";
}