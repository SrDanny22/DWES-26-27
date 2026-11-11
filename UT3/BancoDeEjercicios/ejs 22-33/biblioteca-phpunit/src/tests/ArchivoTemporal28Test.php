<?php

use PHPUnit\Framework\TestCase;

class ArchivoTemporal28Test extends TestCase
{
    private ?string $ruta = null;

    protected function tearDown(): void
    {
        if ($this->ruta !== null && is_file($this->ruta)) {
            unlink($this->ruta);
        }

        if ($this->ruta !== null) {
            $this->assertFileDoesNotExist($this->ruta);
        }
    }

    public function testEscribeEnArchivoTemporal(): void
    {
        $ruta = tempnam(sys_get_temp_dir(), "biblioteca");
        $this->assertIsString($ruta);
        $this->ruta = $ruta;

        file_put_contents($this->ruta, "Dune");

        $this->assertSame("Dune", file_get_contents($this->ruta));
    }
}
