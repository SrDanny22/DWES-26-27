<?php

declare(strict_types=1);

function limpiarEspacios(string $texto): string
{
    // TODO 1: limpiar extremos y agrupar espacios consecutivos.
    // HECHO
    return preg_replace('/\s+/', ' ', trim($texto));;
}

function normalizarBusqueda(string $texto): string
{
    // REVISAR: ¿funciona con CÁMARA y ÓRBITA?
    // Añado el mb y la codificación UTF-8
    return mb_strtolower(limpiarEspacios($texto), 'UTF-8');
}

function obtenerCategorias(array $equipos): array
{
    // TODO 2: extraer categorías sin duplicados en orden de aparición.
    // HECHO
    return array_values(array_unique(array_column($equipos, 'categoria')));
}

function categoriaValida(string $categoria, array $categorias): bool
{
    // Corregido
    return $categoria === '' || array_search($categoria, $categorias, true) !== false;
}

function unidadesPrestadas(array $prestamos, int $equipoId): int
{
    // TODO 5: sumar unidades de préstamos activos de este equipo.
    // HECHO
    $activos = array_filter(
        $prestamos,
        fn(array $p): bool => $p['equipoId'] === $equipoId && $p['estado'] === 'activo'
    );

    return array_reduce(
        $activos,
        fn(int $suma, array $p): int => $suma + $p['unidades'],
        0
    );
}

// Función facilitada: añade los cálculos a una copia de cada equipo.
function prepararEquipos(array $equipos, array $prestamos): array
{
    return array_map(
        function (array $equipo) use ($prestamos): array {
            $equipo['prestadas'] = unidadesPrestadas($prestamos, $equipo['id']);
            $equipo['disponibles'] = $equipo['unidades'] - $equipo['prestadas'];

            return $equipo;
        },
        $equipos
    );
}

function filtrarEquipos(
    array $equipos,
    string $texto,
    string $categoria,
    bool $soloDisponibles
): array
{
    // TODO 3: filtrar por nombre, categoría y unidades disponibles.
    // HECHO
    $buscar = normalizarBusqueda($texto);

    return array_filter(
        $equipos,
        fn(array $equipo): bool =>
            ($buscar === '' || str_contains(normalizarBusqueda($equipo['nombre']), $buscar))
            && ($categoria === '' || $equipo['categoria'] === $categoria)
            && (!$soloDisponibles || $equipo['disponibles'] > 0)
    );
}

function ordenarEquipos(array $equipos, string $orden): array
{
    // TODO 4: ordenar una copia según el criterio y desempatar por id.
    // HECHO
    usort(
        $equipos,
        function (array $a, array $b) use ($orden): int {
            $comparacion = $orden === 'disponibles'
                ? $a['disponibles'] <=> $b['disponibles']
                : normalizarBusqueda($a['nombre']) <=> normalizarBusqueda($b['nombre']);
            return $comparacion !== 0 ? $comparacion : $a['id'] <=> $b['id'];
        }
    );

    return $equipos;
}

function resumirEquipos(array $equipos): array
{
    return [
        'cantidad' => count($equipos),

        'unidades' => array_reduce(
            $equipos,
            fn(int $s, array $a): int => $s + $a['unidades'],
            0
        ), // REVISAR: cuenta equipos, no unidades. REVISADO

        'prestadas' => array_reduce(
            $equipos,
            fn(int $s, array $a): int => $s + $a['prestadas'],
            0
        ),
        'disponibles' => array_reduce(
            $equipos,
            fn(int $s, array $a): int => $s + $a['disponibles'],
            0
        ), // TODO 6: sumar unidades disponibles. HECHO

        'hayAgotados' =>  array_any($equipos, fn(array $a): bool => $a['disponibles'] === 0), // TODO 7: comprobar si algún equipo está agotado. HECHO
        'todosDisponibles' => array_all($equipos, fn(array $a): bool => $a['disponibles'] > 0), // TODO 8: comprobar si todos tienen disponibilidad. HECHO
    ];
}

// Función facilitada: permite pasar una función como dato.
function transformarNombres(array $nombres, callable $callback): array
{
    return array_map($callback, $nombres);
}

function generarEtiquetas(array $equipos, string $prefijo = 'Equipo: '): array
{
    // TODO 9: extraer nombres y usar una closure que capture el prefijo.
    // HECHO
    $nombres = array_column($equipos, 'nombre');

    return transformarNombres(
        $nombres,
        function (string $nombre) use ($prefijo): string {
            return $prefijo . limpiarEspacios($nombre);
        }
    );
}

// Función facilitada. La entrada web valida el id antes de llamar.
function normalizarId(int|string $id): int
{
    return (int) $id;
}

function buscarPorId(array $equipos, int|string $id): ?array
{
    // TODO 10: buscar por id en todos los equipos; id no es índice.
    // HECHO
    $buscado = normalizarId($id);

    return array_find($equipos, fn(array $equipo): bool => $equipo['id'] === $buscado);
}

function responsableVisible(?string $responsable): string
{
    // TODO 11: resolver el caso de responsable null.
    return $responsable ?? 'Responsable pendiente';
}

function inicioNombre(string $nombre): string
{
    // Corregido
    return mb_substr(limpiarEspacios($nombre), 0, 3, 'UTF-8');
}

function codigoValido(string $codigo): bool
{
    // Corregido
    return preg_match('/^AV-[0-9]{4}-[0-9]{4}\z/', $codigo) === 1;
}
