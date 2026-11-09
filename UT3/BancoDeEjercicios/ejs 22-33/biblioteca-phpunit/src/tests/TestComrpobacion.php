<?php

use App\Model\Libro;
use PHPUnit\Framework\TestCase;

class TestComrpobacion extends TestCase
{
    public function testDisponible(): void
    {
        $libro1 = new Libro("Dune", "Frank Herbert", 412);

        $libro1->prestar();

        $disponible = $libro1->estaDisponible();

        $this->assertFalse($disponible);
    }
}
