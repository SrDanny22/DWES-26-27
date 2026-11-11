<?php

use App\Model\Libro;
use PHPUnit\Framework\TestCase;

class Libro23Test extends TestCase
{
    public function testDisponible(): void
    {
        $libro1 = new Libro("Dune", "Frank Herbert", 412);

        $libro1->prestar();

        $disponible = $libro1->estaDisponible();

        $this->assertFalse($disponible);
    }

    public function testPaginas(): void
    {
        $libro = new Libro("Dune", "Frank Herbert", 412);

        $paginas = $libro->paginas();

        $this->assertSame(412, $paginas);
    }

    public function testAssertSameYAssertEquals(): void
    {
        $libro = new Libro("Dune", "Frank Herbert", 412);

        $paginas = $libro->paginas();

        $this->assertEquals("412", $paginas);
        $this->assertNotSame("412", $paginas);
    }
}
