<?php

use App\Model\Libro;
use PHPUnit\Framework\TestCase;

class TestLibro extends TestCase
{
    public function testConservaTitulo(): void
    {
        $libro = new Libro("Dune", "Frank Herbert", 412);

        $this->assertSame("Dune", $libro->titulo());
    }
}
