<?php

declare(strict_types=1);

use App\Contrato\PeliculaRepository;
use App\Modelo\Pelicula;
use App\Servicio\ConsultaPelicula;
use PHPUnit\Framework\TestCase;

final class ConsultaPeliculaTest extends TestCase
{
    // COMPLETAR 11. Película ausente con un stub.
    public function testStub(): void {
        $repo = $this->createStub(PeliculaRepository::class);
        $repo->method('buscarPorId')->willReturn(null);

        $consulta = new ConsultaPelicula($repo);

        $this->expectException(OutOfBoundsException::class);
        $consulta->obtener(99);
    }

    // COMPLETAR 12. Consulta única del identificador con un mock.
    public function testMock(): void {
        $pelicula = new Pelicula('Chunchunmaru', 'Willyrex', 112, 'fantasia', new DateTimeImmutable('2026-03-05'));

        $repo = $this->createMock(PeliculaRepository::class);
        $repo->expects($this->once())->method('buscarPorId')->with(7)->willReturn($pelicula);

        $consulta = new ConsultaPelicula($repo);

        $this->assertSame($pelicula, $consulta->obtener(7));
    }
}
