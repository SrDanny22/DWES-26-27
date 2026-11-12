<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function App\Soporte\validarVideojuego;

final class HorasTest extends TestCase
{
    // COMPLETAR 9. Proveedor y prueba de los cinco valores de horas.
    public static function casosHoras(): array {
        return [
            'mínimo'    => ['1', true],
            'máximo'    => ['300', true],
            'bajo'      => ['0', false],
            'alto'      => ['301', false],
            'formato'   => ['12abc', false]
        ];
    }
    
    #[DataProvider("casosHoras")]
    public function testHoras(string $entrada, bool $valida): void {
        $post = $this->datosValidos();
        $post['horas'] = $entrada;

        $r = validarVideojuego($post);

        $this->assertSame($valida, !isset($r['errores']['horas']));

        if ($valida) {
            $this->assertSame((int) $entrada, $r['datos']['horas']);
        } else {
            $this->assertNull($r['datos']);
        }
    }

    // Proporcionado. Datos válidos sobre los que varías solo horas.
    private function datosValidos(): array
    {
        return [
            'titulo' => 'Islas de cristal',
            'estudio' => 'Nébula Studio',
            'horas' => '35',
            'genero' => 'aventura',
            'fechaLanzamiento' => '',
        ];
    }
}
