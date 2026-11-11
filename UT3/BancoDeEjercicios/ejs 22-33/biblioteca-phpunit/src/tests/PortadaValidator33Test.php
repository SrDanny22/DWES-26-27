<?php

use App\Service\PortadaValidator;
use PHPUnit\Framework\TestCase;

class PortadaValidator33Test extends TestCase
{
    public function testAceptaUnByte(): void
    {
        $validator = new PortadaValidator();

        $error = $validator->validar(1, "image/jpeg");

        $this->assertNull($error);
    }

    public function testAceptaDosMiB(): void
    {
        $validator = new PortadaValidator();

        $error = $validator->validar(2 * 1024 * 1024, "image/jpeg");

        $this->assertNull($error);
    }

    public function testRechazaDosMiBMasUno(): void
    {
        $validator = new PortadaValidator();

        $error = $validator->validar(2 * 1024 * 1024 + 1, "image/jpeg");

        $this->assertSame("La portada debe ocupar entre 1 byte y 2 MiB.", $error);
    }

    public function testAceptaPng(): void
    {
        $validator = new PortadaValidator();

        $error = $validator->validar(1024, "image/png");

        $this->assertNull($error);
    }

    public function testRechazaTextoPlano(): void
    {
        $validator = new PortadaValidator();

        $error = $validator->validar(1024, "text/plain");

        $this->assertSame("La portada debe ser una imagen JPEG, PNG o WebP.", $error);
    }
}
