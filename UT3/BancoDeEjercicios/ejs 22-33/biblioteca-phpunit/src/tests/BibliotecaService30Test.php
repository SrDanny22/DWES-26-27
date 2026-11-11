<?php

use App\Repository\LibroRepository;
use App\Service\BibliotecaService;
use PHPUnit\Framework\TestCase;

class BibliotecaService30Test extends TestCase
{
    // El stub controla la respuesta de la consulta que hace el servicio: buscarPorId devuelve null
    // y así se prueba el caso inexistente sin crear un repositorio real.
    public function testIdInexistenteConStub(): void
    {
        $repositorio = $this->createStub(LibroRepository::class);
        $repositorio->method("buscarPorId")->willReturn(null);
        $servicio = new BibliotecaService($repositorio);

        $this->expectException(OutOfBoundsException::class);

        $servicio->prestar(999);
    }
}
