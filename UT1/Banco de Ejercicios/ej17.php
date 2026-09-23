<?php

$libros = [
    [
        "titulo" => "Libro1",
        "autor" => "Autor1",
    ],
    [
        "titulo" => "Libro2",
        "autor" => "Autor2",
    ],
    [
        "titulo" => "Libro3",
        "autor" => "Autor3",
    ],
    [
        "titulo" => "Libro4",
        "autor" => "Autor4",
    ],
];

foreach ($libros as $libro) {
    echo "Titulo: " . $libro['titulo'] . "<br>" . "Autor: " . $libro['autor'] . "<br>";
}