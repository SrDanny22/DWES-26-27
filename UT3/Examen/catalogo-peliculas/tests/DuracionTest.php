<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function App\Soporte\validarPelicula;

final class DuracionTest extends TestCase
{
    // COMPLETAR 9. Proveedor y prueba de las cinco duraciones.
    public static function duraciones(): array {
        return [
            'mínimo' => ['1', true],
            'máximo' => ['300', true],
            'bajo' => ['0', false],
            'alto' => ['301', false],
            'formato' => ['12abc', false],
        ];
    }

    #[DataProvider('duraciones')]
    public function testProveedorDuraciones(string $entrada, bool $valida) {
        $post = $this->datosValidos();
        $post['duracion'] = $entrada;

        $r = validarPelicula($post);

        $this->assertSame($valida, !isset($r['errores']['duracion']));

        if ($valida) {
            $this->assertSame((int) $entrada, $r['datos']['duracion']);
        } else {
            $this->assertNull($r['datos']);
        }
    }

    // Proporcionado. Datos válidos sobre los que varías solo duracion.
    private function datosValidos(): array
    {
        return [
            'titulo' => 'Dune',
            'director' => 'Denis Villeneuve',
            'duracion' => '155',
            'genero' => 'ciencia',
            'fechaEstreno' => '',
        ];
    }
}
