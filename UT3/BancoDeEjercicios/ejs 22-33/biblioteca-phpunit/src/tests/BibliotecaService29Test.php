<?php

use App\Model\Libro;
use App\Repository\ArrayLibroRepository;
use App\Service\BibliotecaService;
use PHPUnit\Framework\TestCase;

class BibliotecaService29Test extends TestCase
{
    public function testPrestaLibroGuardado(): void
    {
        $repositorio = new ArrayLibroRepository();
        $id = $repositorio->guardar(new Libro("Dune", "Frank Herbert", 412));
        $servicio = new BibliotecaService($repositorio);

        $servicio->prestar($id);

        $this->assertFalse($repositorio->buscarPorId($id)->estaDisponible());
    }

    public function testIdAusenteLanzaExcepcion(): void
    {
        $servicio = new BibliotecaService(new ArrayLibroRepository());

        $this->expectException(OutOfBoundsException::class);

        $servicio->prestar(999);
    }
}
