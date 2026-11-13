<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use function App\Soporte\inspeccionarCartel;

final class CartelTemporalTest extends TestCase
{
    private ?string $temporal = null;

    // COMPLETAR 10. setUp, prueba de rechazo y tearDown.
    protected function setUp(): void {
        $ruta = tempnam(sys_get_temp_dir(), "ut3_");

        if ($ruta === false) {
            throw new RuntimeException('La ruta no es válida.');
        }
        
        $this->temporal = $ruta;
        file_put_contents($ruta, 'Esto no es una imagen.');
    }

    public function testInspeccionarCartel(): void {
        $cartel = inspeccionarCartel($this->entradaArchivo());

        $this->assertNull($cartel['archivo']);
        $this->assertNotNull($cartel['error']);
    }

    protected function tearDown(): void {
        if ($this->temporal !== null && file_exists($this->temporal)) {
            unlink($this->temporal);
            $this->assertFalse(file_exists($this->temporal));
        }
    }

    // Proporcionado. Representa el temporal como entrada de inspeccionarCartel.
    private function entradaArchivo(): array
    {
        if ($this->temporal === null || !is_file($this->temporal)) {
            throw new RuntimeException('El temporal de prueba no está preparado.');
        }

        return [
            'cartel' => [
                'error' => UPLOAD_ERR_OK,
                'size' => filesize($this->temporal),
                'tmp_name' => $this->temporal,
            ],
        ];
    }
}
