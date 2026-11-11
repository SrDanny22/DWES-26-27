<?php

use App\Service\LibroFormService;
use App\Service\Validator;
use PHPUnit\Framework\TestCase;

class LibroFormService27Test extends TestCase
{
    private function procesar(array $cambios = []): array
    {
        $servicio = new LibroFormService(new Validator());
        $entrada = [
            "titulo" => " Dune ",
            "autor" => "Frank Herbert",
            "paginas" => "412",
            "genero" => "ciencia",
            "fechaAlta" => "",
        ];

        return $servicio->procesar(array_merge($entrada, $cambios));
    }

    public function testSalidaCompleta(): void
    {
        $resultado = $this->procesar();

        $this->assertSame("412", $resultado["valores"]["paginas"]);
        $this->assertSame(412, $resultado["datos"]["paginas"]);
        $this->assertSame("Dune", $resultado["valores"]["titulo"]);
        $this->assertSame("Dune", $resultado["datos"]["titulo"]);
        $this->assertSame([], $resultado["errores"]);
        $this->assertNull($resultado["datos"]["fechaAlta"]);
    }

    public function testFechaValida(): void
    {
        $resultado = $this->procesar(["fechaAlta" => "2026-10-24"]);

        $this->assertInstanceOf(DateTimeImmutable::class, $resultado["datos"]["fechaAlta"]);
        $this->assertSame("2026-10-24", $resultado["datos"]["fechaAlta"]->format("Y-m-d"));
    }

    public function testFechaImposible(): void
    {
        $resultado = $this->procesar(["fechaAlta" => "2026-02-31"]);

        $this->assertArrayHasKey("fechaAlta", $resultado["errores"]);
        $this->assertNull($resultado["datos"]);
    }

    public function testTituloDe120Caracteres(): void
    {
        $resultado = $this->procesar(["titulo" => str_repeat("a", 120)]);

        $this->assertArrayNotHasKey("titulo", $resultado["errores"]);
        $this->assertNotNull($resultado["datos"]);
    }

    public function testTituloDe121Caracteres(): void
    {
        $resultado = $this->procesar(["titulo" => str_repeat("a", 121)]);

        $this->assertArrayHasKey("titulo", $resultado["errores"]);
        $this->assertNull($resultado["datos"]);
    }

    public function testTituloArray(): void
    {
        $resultado = $this->procesar(["titulo" => ["Dune"]]);

        $this->assertSame("Debe ser texto.", $resultado["errores"]["titulo"]);
        $this->assertNull($resultado["datos"]);
    }

    public function testGeneroNoValido(): void
    {
        $resultado = $this->procesar(["genero" => "aventura"]);

        $this->assertArrayHasKey("genero", $resultado["errores"]);
        $this->assertNull($resultado["datos"]);
    }
}
