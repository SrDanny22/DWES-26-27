<?php

$catalogo_libros = [
    [
        "id"         => 1,
        "titulo"     => "Un mago de Terramar",
        "autor"      => "Ursula K. Le Guin",
        "genero"     => "Narrativo (Fantasía)",
        "numpaginas" => 272
    ],
    [
        "id"         => 2,
        "titulo"     => "Los desposeídos",
        "autor"      => "Ursula K. Le Guin",
        "genero"     => "Narrativo (Ciencia Ficción)",
        "numpaginas" => 384
    ],
    [
        "id"         => 3,
        "titulo"     => "Don Quijote de la Mancha",
        "autor"      => "Miguel de Cervantes",
        "genero"     => "Narrativo (Novela)",
        "numpaginas" => 1032
    ],
    [
        "id"         => 4,
        "titulo"     => "Cien años de soledad",
        "autor"      => "Gabriel García Márquez",
        "genero"     => "Narrativo (Realismo Mágico)",
        "numpaginas" => 502
    ],
    [
        "id"         => 5,
        "titulo"     => "La mano izquierda de la oscuridad",
        "autor"      => "Ursula K. Le Guin",
        "genero"     => "Narrativo (Ciencia Ficción)",
        "numpaginas" => 336
    ],
    [
        "id"         => 6,
        "titulo"     => "Antología Poética",
        "autor"      => "Federico García Lorca",
        "genero"     => "Lírico (Poesía)",
        "numpaginas" => 640
    ]
];

foreach ($catalogo_libros as $libro) {
    if ($libro["autor"] === "Ursula K. Le Guin") {
        echo print_r($libro) . "<br>";
    }
}