<?php
declare(strict_types=1);

function entrada(array $origen, string $clave, string $defecto = ''): string
{
    // F1. Una clave ausente, null o un array devuelve el defecto.
    if (isset($origen[$clave]) && is_string($origen[$clave])) {
        return $origen[$clave];
    }

    return $defecto;
}

function enteroPositivo(string $valor): int
{
    // F2. Valida antes de convertir: 1.5 o texto se rechazan.
    $entero = filter_var($valor, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($entero === false) {
        throw new InvalidArgumentException('Indica un entero positivo.');
    }

    return $entero;
}

function limpiarEspacios(string $texto): string
{
    return preg_replace('/\s+/u', ' ', trim($texto)) ?? '';
}

function normalizar(string $texto): string
{
    return mb_strtolower(limpiarEspacios($texto), 'UTF-8');
}

function buscarPorId(array $actividades, int $id): ?Actividad
{
    // F3. Devuelve el mismo objeto encontrado o null.
    return array_find($actividades, fn(Actividad $actividad): bool => $actividad->id() === $id);
}

function filtrarActividades(
    array $actividades, string $texto, string $tipo,
    ?EstadoActividad $estado, bool $soloDisponibles
): array {
    // F4. Las cuatro condiciones se combinan con AND.
    $texto = normalizar($texto);

    $filtradas = array_filter(
        $actividades,
        function (Actividad $actividad) use ($texto, $tipo, $estado, $soloDisponibles): bool {
            if ($texto !== '' && !str_contains(normalizar($actividad->nombre()), $texto)) {
                return false;
            }
            if ($tipo !== '' && $actividad->tipo() !== $tipo) {
                return false;
            }
            if ($estado !== null && $actividad->estado() !== $estado) {
                return false;
            }
            if ($soloDisponibles
                && ($actividad->estado() !== EstadoActividad::Abierta || $actividad->plazasLibres() <= 0)) {
                return false;
            }

            return true;
        }
    );

    return array_values($filtradas);
}

function ordenarActividades(array $actividades, string $orden): array
{
    // F5. El array llega por valor: usort ordena una copia, no el catálogo original.
    usort($actividades, function (Actividad $a, Actividad $b) use ($orden): int {
        $comparacion = $orden === 'libres'
            ? $a->plazasLibres() <=> $b->plazasLibres()
            : normalizar($a->nombre()) <=> normalizar($b->nombre());

        return $comparacion !== 0 ? $comparacion : $a->id() <=> $b->id();
    });

    return $actividades;
}

function transformarActividades(array $actividades, callable $transformacion): array
{
    return array_map($transformacion, $actividades);
}

function generarEtiquetas(
    array $actividades, string $prefijo = 'Actividad: '
): array
{
    // F6. La closure captura el prefijo con use; array_map conserva el orden.
    return transformarActividades(
        $actividades,
        function (Actividad $actividad) use ($prefijo): string {
            return $actividad->etiqueta($prefijo);
        }
    );
}

function resumirActividades(array $actividades): array
{
    // F7. Cada clase hija calcula su propio importe.
    return array_reduce(
        $actividades,
        function (array $resumen, Actividad $actividad): array {
            $resumen['cantidad']++;
            $resumen['capacidad'] += $actividad->capacidad();
            $resumen['ocupadas'] += $actividad->ocupadas();
            $resumen['libres'] += $actividad->plazasLibres();
            $resumen['importe'] += $actividad->importe($actividad->ocupadas());

            return $resumen;
        },
        ['cantidad' => 0, 'capacidad' => 0, 'ocupadas' => 0, 'libres' => 0, 'importe' => 0]
    );
}

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function euros(int $centimos): string
{
    return number_format($centimos / 100, 2, ',', '.') . ' €';
}
