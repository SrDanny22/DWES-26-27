<?php

use App\Model\Libro;
use PHPUnit\Framework\TestCase;

class Libro28Test extends TestCase
{
    private Libro $libro;

    protected function setUp(): void
    {
        $this->libro = new Libro("Dune", "Frank Herbert", 412);
    }

    public function testDisponibleAlCrearlo(): void
    {
        $disponible = $this->libro->estaDisponible();

        $this->assertTrue($disponible);
    }

    public function testNoDisponibleTrasPrestarlo(): void
    {
        $this->libro->prestar();

        $disponible = $this->libro->estaDisponible();

        $this->assertFalse($disponible);
    }
}
