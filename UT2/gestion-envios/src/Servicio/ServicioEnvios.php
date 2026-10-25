<?php

declare(strict_types=1);

namespace App\Servicio;

use App\Contrato\RepositorioEnvios;
use App\Excepcion\EnvioException;
use App\Modelo\Envio;
use App\Modelo\EstadoEnvio;
use InvalidArgumentException;

final class ServicioEnvios
{
    public function __construct(private RepositorioEnvios $repositorio)
    {
    }

    public function enviar(int $id): void
    {
        $this->obtener($id)->enviar();
    }

    public function entregar(int $id): void
    {
        $this->obtener($id)->entregar();
    }

    public function cancelar(int $id): void
    {
        $this->obtener($id)->cancelar();
    }

    public function consultar(
        string $texto = '', ?string $modalidad = null,
        ?EstadoEnvio $estado = null, string $orden = 'precio'
    ): array {
        if ($modalidad !== null && $modalidad !== 'normal' && $modalidad !== 'urgente') {
            throw new InvalidArgumentException('Modalidad desconocida: "' . $modalidad . '"');
        }

        if ($orden !== 'precio' && $orden !== 'peso') {
            throw new InvalidArgumentException('Orden desconocido: "' . $orden . '"');
        }

        $texto = self::normalizar($texto);

        $resultado = array_filter(
            $this->repositorio->todos(),
            fn (Envio $envio): bool =>
                str_contains(self::normalizar($envio->cliente()), $texto)
                && ($modalidad === null || $envio->modalidad() === $modalidad)
                && ($estado === null || $envio->estado() === $estado)
        );

        usort($resultado, function (Envio $a, Envio $b) use ($orden): int {
            $principal = $orden === 'precio'
                ? $a->tarifa() <=> $b->tarifa()
                : $a->peso() <=> $b->peso();

            return $principal !== 0
                ? $principal
                : $a->id() <=> $b->id();
        });

        return $resultado;
    }

    public function etiquetas(array $envios): array
    {
        return array_map(
            fn (Envio $envio): string =>
                $envio->id() . ' | ' . $envio->cliente() . ' | ' . $envio->modalidad()
                . ' | ' . $envio->estado()->value . ' | ' . $envio->tarifa() . ' céntimos',
            $envios
        );
    }

    public function resumir(array $envios): array
    {
        return array_reduce(
            $envios,
            function (array $resumen, Envio $envio): array {
                $resumen['cantidad']++;
                $resumen['peso'] += $envio->peso();
                $resumen['importeTotal'] += $envio->tarifa();

                if ($envio->estado() !== EstadoEnvio::Cancelado) {
                    $resumen['importeActivo'] += $envio->tarifa();
                }

                $resumen[$envio->estado()->value]++;

                return $resumen;
            },
            [
                'cantidad' => 0, 'peso' => 0,
                'importeTotal' => 0, 'importeActivo' => 0,
                'pendiente' => 0, 'enviado' => 0,
                'entregado' => 0, 'cancelado' => 0
            ]
        );
    }

    private function obtener(int $id): Envio
    {
        $envio = $this->repositorio->buscar($id);

        if ($envio === null) {
            throw new EnvioException('No existe ningún envío con el id ' . $id);
        }

        return $envio;
    }

    private static function normalizar(string $texto): string
    {
        return mb_strtolower(preg_replace('/\s+/', ' ', trim($texto)), 'UTF-8');
    }
}
