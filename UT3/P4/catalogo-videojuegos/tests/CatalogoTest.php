<?php

declare(strict_types=1);

use App\Modelo\Videojuego;
use PHPUnit\Framework\TestCase;

final class CatalogoTest extends TestCase
{
    // COMPLETAR 8. Creación válida y estado del objeto.
    public function testCreacionValida(): void {
        $juego = new Videojuego(' Islas de cristal ', ' Nébula Studio ', 35, 'aventura');

        $this->assertSame('Islas de cristal', $juego->titulo());
        $this->assertSame('Nébula Studio', $juego->estudio());
        $this->assertSame(35, $juego->horas());
        $this->assertNull($juego->fechaLanzamiento());
    }

}
