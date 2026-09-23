<?php

$catalogo_libros = [
    [
        "id"         => 1,
        "titulo"     => "Un mago de Terramar",
        "autor"      => "Ursula K. Le Guin",
        "genero"     => "Narrativo (Fantasía)",
        "numpaginas" => 272,
        "disponible" => true
    ],
    [
        "id"         => 2,
        "titulo"     => "Los desposeídos",
        "autor"      => "Ursula K. Le Guin",
        "genero"     => "Narrativo (Ciencia Ficción)",
        "numpaginas" => 502,
        "disponible" => false
    ],
    [
        "id"         => 3,
        "titulo"     => "Don Quijote de la Mancha",
        "autor"      => "Miguel de Cervantes",
        "genero"     => "Narrativo (Novela)",
        "numpaginas" => 1032,
        "disponible" => true
    ],
    [
        "id"         => 4,
        "titulo"     => "Cien años de soledad",
        "autor"      => "Gabriel García Márquez",
        "genero"     => "Narrativo (Realismo Mágico)",
        "numpaginas" => 496,
        "disponible" => true
    ],
    [
        "id"         => 5,
        "titulo"     => "La mano izquierda de la oscuridad",
        "autor"      => "Ursula K. Le Guin",
        "genero"     => "Narrativo (Ciencia Ficción)",
        "numpaginas" => 777,
        "disponible" => false
    ],
    [
        "id"         => 6,
        "titulo"     => "Antología Poética",
        "autor"      => "Federico García Lorca",
        "genero"     => "Lírico (Poesía)",
        "numpaginas" => 240,
        "disponible" => true
    ]
];
$contador = 0;
foreach ($catalogo_libros as $libro) {
    if ($libro["disponible"] === true && $libro["numpaginas"] < 500) {
        echo print_r($libro) . "<br>";
        $contador++;
    }
}
echo "Libros que cumplen las condiciones: $contador";