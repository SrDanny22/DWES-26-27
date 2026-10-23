<?php

declare(strict_types=1);

class Autor {
    public string $nombre;

    public function __construct(string $nombre) {
        $this->nombre = $nombre;
    }
}
    
class Categoria {
    public string $nombre;

    public function __construct(string $nombre) {
        $this->nombre = $nombre;
    }
}

class Libro {
    public string $titulo;
    public Autor $autor;
    public Categoria $categoria;

    public function __construct(string $titulo, Autor $autor, Categoria $categoria) {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->categoria = $categoria;
    }
}

$autor = new Autor('Frank Herbert');
$categoria = new Categoria('Ciencia ficción');

$libro = new Libro('Dune', $autor, $categoria);

echo "Título: " . $libro->titulo . "<br>";
echo "Autor: " . $libro->autor->nombre . "<br>";
echo "Categoría: " . $libro->categoria->nombre . "<br>";
