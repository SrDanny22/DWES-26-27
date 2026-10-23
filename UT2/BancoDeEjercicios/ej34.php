<?php

declare(strict_types=1);

// public final class Libro {
//  public String titulo;
//  public boolean disponible;
//  public Libro(String titulo) {
//  this.titulo = titulo;
//  this.disponible = true;
//  }
//  public void prestar() {
//  this.disponible = false;
//  }
// }


final class Libro {
    public string $titulo;
    public bool $disponible;

    public function __construct(string $titulo)
    {
        $this->titulo = $titulo;
        $this->disponible = true;
    }

    public function prestar(): void {
        $this->disponible = false;
    }
}

$libro = new Libro('Dune');

echo $libro->disponible ? 'true' : 'false';

echo '<br>';

$libro->prestar();

echo $libro->disponible ? 'true' : 'false';


// this y $this seria lo mismo, solo que en php se le pondría el $, y entre el . y el ->, es la manera para llamar a la propiedad o metodo.