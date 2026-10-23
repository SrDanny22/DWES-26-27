<?php

declare(strict_types=1);

class ServicioAlquileres {
    private array $alquileres;

    public function __construct(array $alquileres)
    {
        $this->alquileres = $alquileres;
    }

    public function todos(): array {
        return $this->alquileres;
    }


    private function normalizar(string $texo): string {
        return mb_strtolower(trim($texo), 'UTF-8');
    }

    public function consultar(string $texto = '', ?EstadoAlquiler $estado = null): array {
        $consulta = array_filter(
            $this->alquileres,
            fn (Alquiler $a): bool =>
                (str_contains($this->normalizar($a->cliente()), $this->normalizar($texto))) &&
                ($estado === null || $estado === $a->estado())
                
        );

        usort(
            $consulta,
            fn (Alquiler $a, Alquiler $b): int =>
                $a->importe() <=> $b->importe());

        if (count($consulta) === 0) {
            return [];
        }
        return array_values($consulta);
    }

    public function resumir(array $alquileres): array {
        $total = array_reduce(
            $alquileres,
            fn(int $carry, Alquiler $importe) => $importe->importe() + $carry,
            0);

        if (count($alquileres) === 0) {
            return [0, 0];
        }
        
        return [count($alquileres), $total];
    }
}