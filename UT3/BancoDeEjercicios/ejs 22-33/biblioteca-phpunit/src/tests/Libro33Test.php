<?php

use App\Model\Libro;
use PHPUnit\Framework\TestCase;

class Libro33Test extends TestCase
{
    public function testPrestarDejaElLibroNoDisponible(): void
    {
        $libro = new Libro("Dune", "Frank Herbert", 412);

        $libro->prestar();

        // Sin esta aserción el test solo demuestra que prestar() no lanza excepciones;
        // pasaría igual aunque prestar() no cambiara el estado del libro.
        $this->assertFalse($libro->estaDisponible());
    }
}
