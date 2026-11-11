<?php

use App\Service\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class Validator25Test extends TestCase
{
    public static function titulosVacios(): array
    {
        return [
            "cadena vacía" => [""],
            "espacios" => ["   "],
            "tabulación" => ["\t"],
        ];
    }

    #[DataProvider("titulosVacios")]
    public function testTituloRequerido(string $titulo): void
    {
        $validator = new Validator();

        $mensaje = $validator->requerido($titulo, "Escribe el título.");

        $this->assertSame("Escribe el título.", $mensaje);
    }

    public function testTituloConTexto(): void
    {
        $validator = new Validator();

        $mensaje = $validator->requerido("Dune", "Escribe el título.");

        $this->assertNull($mensaje);
    }
}
