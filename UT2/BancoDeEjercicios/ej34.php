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

    public function __construct(string $titulo, bool $disponible)
    {
        $this->titulo = $titulo;
        $this->disponible = $disponible = true;
    }
}