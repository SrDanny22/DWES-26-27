<?php

declare(strict_types=1);

namespace Escuela\Curso\Servicio;

use Escuela\Curso\Contrato\CursoRepository;
use Escuela\Curso\Excepcion\CursoException;
use Escuela\Curso\Modelo\{Curso, EstadoCurso};
use InvalidArgumentException;

final class CatalogoService
{
    public function __construct(private CursoRepository $repository)
    {
    }

    public function filtrar(
        string $texto = '',
        ?EstadoCurso $estado = null,
        bool $soloConPlazas = false
    ): array
    {
        $texto = mb_strtolower(trim($texto), 'UTF-8');

        // TODO F1: filtra los cursos mediante array_filter.
        $filtrado = array_filter(
            $this->repository->todos(),
            fn(Curso $e): bool =>
                (str_contains($e->nombreNormalizado(), $texto)) &&
                ($estado === null || $e->estado() === $estado) &&
                ($soloConPlazas === false || ($e->estado() === EstadoCurso::Abierto && $e->plazasLibres() > 0))
        );

        return array_values($filtrado);
    }

    public function ordenar(array $cursos): array
    {
        // TODO F2: ordena una copia mediante usort y un callback.
        $copiaCursos = $cursos;

        usort(
            $copiaCursos,
            function (Curso $a, Curso $b): int {
                $precioPlaza = $a->precioPlaza() <=> $b->precioPlaza();

                if ($precioPlaza !== 0) {
                    return $precioPlaza;
                }

                return $a->id() <=> $b->id();
            }
        );

        return $copiaCursos;
    }

    public function etiquetas(array $cursos, string $prefijo = 'Curso: '): array
    {
        // TODO F3: array_map y arrow function.
        $etiquetas = array_map(
            fn (Curso $e): string =>
                $e->etiqueta($prefijo),
            $cursos
        );

        return $etiquetas;
    }

    public function resumen(array $cursos): array
    {
        // TODO F4: calcula las tres cifras mediante array_reduce.
        $resumen = array_reduce(
            $cursos,
            fn(array $carry, Curso $e): array => [
                'cantidad' => count($cursos),
                'libres' => $e->plazasLibres() + $carry['libres'],
                'importeCentimos' => ($e->ocupadas() * $e->precioPlaza()) + $carry['importeCentimos']
            ],
            ['libres' => 0, 'importeCentimos' => 0]
        );

        return $resumen;
    }

    public function buscarOpciones(int $plazas, int $presupuestoCentimos): array
    {
        // TODO D1: repara las etapas de esta búsqueda sin utilizar bucles.
        if ($plazas <= 0 || $presupuestoCentimos < 0) {
            throw new \InvalidArgumentException('Plazas o presupuesto no válidos');
        }

        $candidatos = array_filter(
            $this->repository->todos(),
            fn (Curso $curso): bool =>
                $curso->estado() === EstadoCurso::Abierto
                && $curso->plazasLibres() >= $plazas
        );

        $propuestas = array_map(
            fn (Curso $curso): array => [
                'id' => $curso->id(),
                'importeCentimos' => $plazas * $curso->precioPlaza(),
                'libresDespues' => $curso->plazasLibres() - $plazas
            ],
            $candidatos
        );

        $resultado = array_reduce(
            $propuestas,
            function (array $acumulado, array $propuesta) use ($presupuestoCentimos): array {
                // $disponible = $presupuestoCentimos - $acumulado['importeAcumulado'];

                if ($propuesta['importeCentimos'] <= $presupuestoCentimos) {
                    $acumulado[] = $propuesta;
                }

                return $acumulado;
            },
            []
        );

        usort(
            $propuestas,
            fn (array $a, array $b): int =>
                (($a['importeCentimos'] <=> $b['importeCentimos']) !== 0)
                    ? ($a['importeCentimos'] <=> $b['importeCentimos'])
                    : ($a['id'] <=> $b['id'])
        );

        return $resultado;
    }

    private function requerido(int $id): Curso
    {
        return $this->repository->buscarPorId($id)
            ?? throw new CursoException('El curso no existe');
    }

    public function reservar(int $id, int $cantidad): void
    {
        $this->requerido($id)->reservar($cantidad);
    }

    public function cancelar(int $id, int $cantidad): void
    {
        $this->requerido($id)->cancelar($cantidad);
    }

    // Opcional
    
    // public function planificarReserva(int $plazas, int $presupuestoCentimos): array {
    //     if ($plazas <= 0 && $presupuestoCentimos < 0) {
    //         throw new InvalidArgumentException('No se puede completar la reserva');
    //     }

    //     $filtrado = array_filter(
    //         $this->repository->todos(),

    //     );
    //     return [];
    // }
}


