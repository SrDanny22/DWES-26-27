<?php

use App\Service\LibroFormService;
use App\Service\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class LibroFormService26Test extends TestCase
{
    public static function paginas(): array
    {
        return [
            "1" => ["1", true],
            "3000" => ["3000", true],
            "0" => ["0", false],
            "3001" => ["3001", false],
            "12abc" => ["12abc", false],
            "12.5" => ["12.5", false],
            "array" => [["412"], false],
        ];
    }

    #[DataProvider("paginas")]
    public function testValidaPaginas(mixed $paginas, bool $aceptada): void
    {
        $servicio = new LibroFormService(new Validator());
        $entrada = [
            "titulo" => "Dune",
            "autor" => "Frank Herbert",
            "paginas" => "412",
            "genero" => "ciencia",
            "fechaAlta" => "",
        ];
        $entrada["paginas"] = $paginas;

        $resultado = $servicio->procesar($entrada);

        if ($aceptada) {
            $this->assertArrayNotHasKey("paginas", $resultado["errores"]);
            $this->assertSame((int) $paginas, $resultado["datos"]["paginas"]);
        } else {
            $this->assertArrayHasKey("paginas", $resultado["errores"]);
            $this->assertNull($resultado["datos"]);
        }
    }
}
