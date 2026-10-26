<?php

declare(strict_types=1);

use App\Excepcion\EnvioException;
use App\Modelo\EnvioNormal;
use App\Modelo\EnvioUrgente;
use App\Modelo\EstadoEnvio;
use App\Repositorio\RepositorioEnviosMemoria;
use App\Servicio\ServicioEnvios;
use InvalidArgumentException;

require __DIR__ . '/vendor/autoload.php';

function titulo(string $texto): void
{
    echo PHP_EOL . '=== ' . $texto . ' ===' . PHP_EOL;
}

function ids(array $envios): string
{
    if ($envios === []) {
        return 'Ninguno';
    }

    $texto = '';

    foreach ($envios as $envio) {
        $texto = $texto === '' ? (string) $envio->id() : $texto . ', ' . $envio->id();
    }

    return $texto;
}

function mostrarResumen(array $resumen): void
{
    echo '  Resumen: ' . $resumen['cantidad'] . ' envíos · ' . $resumen['peso'] . ' g'
        . ' · importe total ' . $resumen['importeTotal'] . ' céntimos'
        . ' · importe activo ' . $resumen['importeActivo'] . ' céntimos' . PHP_EOL;

    echo '  Estados: ' . $resumen['pendiente'] . ' pendiente · ' . $resumen['enviado'] . ' enviado'
        . ' · ' . $resumen['entregado'] . ' entregado · ' . $resumen['cancelado'] . ' cancelado' . PHP_EOL;
}

function mostrarListado(ServicioEnvios $servicio, array $envios): void
{
    $etiquetas = $servicio->etiquetas($envios);

    if ($etiquetas === []) {
        echo '  Sin resultados' . PHP_EOL;
    }

    foreach ($etiquetas as $etiqueta) {
        echo '  ' . $etiqueta . PHP_EOL;
    }

    mostrarResumen($servicio->resumir($envios));
}

function comprobar(string $descripcion, bool $correcto): void
{
    echo '  [' . ($correcto ? 'OK' : 'FALLO') . '] ' . $descripcion . PHP_EOL;
}

function intentar(string $descripcion, callable $operacion): void
{
    try {
        $operacion();
        echo '  ' . $descripcion . ': correcto' . PHP_EOL;
    } catch (InvalidArgumentException $e) {
        echo '  ' . $descripcion . ': rechazado (InvalidArgumentException) ' . $e->getMessage() . PHP_EOL;
    } catch (EnvioException $e) {
        echo '  ' . $descripcion . ': rechazado (EnvioException) ' . $e->getMessage() . PHP_EOL;
    }
}

function esperarExcepcion(string $descripcion, string $esperada, callable $operacion): void
{
    try {
        $operacion();
        comprobar($descripcion . ' → no lanzó ninguna excepción', false);
    } catch (InvalidArgumentException $e) {
        comprobar(
            $descripcion . ' → InvalidArgumentException: ' . $e->getMessage(),
            $esperada === 'InvalidArgumentException'
        );
    } catch (EnvioException $e) {
        comprobar(
            $descripcion . ' → EnvioException: ' . $e->getMessage(),
            $esperada === 'EnvioException'
        );
    }
}

$repositorio = new RepositorioEnviosMemoria();

$iniciales = [
    new EnvioNormal(101, 'Librería Órbita', 1000, EstadoEnvio::Pendiente),
    new EnvioUrgente(102, 'Taller Norte', 1500, EstadoEnvio::Enviado),
    new EnvioNormal(103, 'Café Álamo', 2500, EstadoEnvio::Entregado),
    new EnvioUrgente(104, 'Estudio Prisma', 500, EstadoEnvio::Cancelado),
    new EnvioNormal(105, 'Papelería Sol', 2000, EstadoEnvio::Pendiente),
    new EnvioUrgente(106, 'Órbita Creativa', 1001, EstadoEnvio::Pendiente)
];

foreach ($iniciales as $envio) {
    $repositorio->registrar($envio);
}

$servicio = new ServicioEnvios($repositorio);

titulo('5.1 Catálogo inicial');
mostrarListado($servicio, $repositorio->todos());

titulo('5.2 Consultas');

$consultas = [
    ['Sin filtros', fn (): array => $servicio->consultar()],
    ['Texto «  ÓRBITA  »', fn (): array => $servicio->consultar('  ÓRBITA  ')],
    ['Modalidad urgente', fn (): array => $servicio->consultar(modalidad: 'urgente')],
    ['Estado pendiente', fn (): array => $servicio->consultar(estado: EstadoEnvio::Pendiente)],
    [
        'Texto ÓRBITA, urgente y pendiente',
        fn (): array => $servicio->consultar('ÓRBITA', 'urgente', EstadoEnvio::Pendiente)
    ],
    ['Texto «  ÓRBITA   CREATIVA  »', fn (): array => $servicio->consultar('  ÓRBITA   CREATIVA  ')],
    ['Texto xyz', fn (): array => $servicio->consultar('xyz')],
    ['Sin filtros y orden por peso', fn (): array => $servicio->consultar(orden: 'peso')]
];

foreach ($consultas as [$descripcion, $consulta]) {
    $resultado = $consulta();
    echo PHP_EOL . '- ' . $descripcion . ' → ' . ids($resultado) . PHP_EOL;
    mostrarListado($servicio, $resultado);
}

echo PHP_EOL;

comprobar(
    'todos() conserva el orden 101…106: ' . ids($repositorio->todos()),
    ids($repositorio->todos()) === '101, 102, 103, 104, 105, 106'
);

comprobar(
    'El resumen del catálogo sigue siendo el inicial',
    $servicio->resumir($repositorio->todos())['importeTotal'] === 4570
);

comprobar(
    'Dos llamadas a buscar(101) devuelven la misma instancia',
    $repositorio->buscar(101) === $repositorio->buscar(101)
);

titulo('6.1 Operaciones');

$operaciones = [
    ['Enviar 101', 101, fn () => $servicio->enviar(101)],
    ['Cancelar 101', 101, fn () => $servicio->cancelar(101)],
    ['Entregar 101', 101, fn () => $servicio->entregar(101)],
    ['Enviar 101', 101, fn () => $servicio->enviar(101)],
    ['Cancelar 105', 105, fn () => $servicio->cancelar(105)],
    ['Enviar 105', 105, fn () => $servicio->enviar(105)],
    ['Entregar 102', 102, fn () => $servicio->entregar(102)],
    ['Cancelar 104', 104, fn () => $servicio->cancelar(104)],
    ['Entregar 106', 106, fn () => $servicio->entregar(106)],
    ['Enviar 999', 999, fn () => $servicio->enviar(999)]
];

foreach ($operaciones as $paso => [$descripcion, $id, $operacion]) {
    intentar(($paso + 1) . '. ' . $descripcion, $operacion);

    $envio = $repositorio->buscar($id);

    if ($envio !== null) {
        echo '      estado actual: ' . $envio->estado()->value . PHP_EOL;
    }
}

echo PHP_EOL . '- Catálogo tras las operaciones' . PHP_EOL;
mostrarListado($servicio, $repositorio->todos());
echo PHP_EOL . '- Pendientes → ' . ids($servicio->consultar(estado: EstadoEnvio::Pendiente)) . PHP_EOL;

$final = $servicio->resumir($repositorio->todos());

comprobar(
    '1 pendiente, 0 enviados, 3 entregados y 2 cancelados',
    $final['pendiente'] === 1 && $final['enviado'] === 0
    && $final['entregado'] === 3 && $final['cancelado'] === 2
);

comprobar(
    '6 envíos, 8501 g, 4570 céntimos de total y 3180 de activo',
    $final['cantidad'] === 6 && $final['peso'] === 8501
    && $final['importeTotal'] === 4570 && $final['importeActivo'] === 3180
);

titulo('6.2 Datos inválidos en el constructor');

$invalidos = [
    ['id 0', 0, 'Cliente', 1000],
    ['id -1', -1, 'Cliente', 1000],
    ['cliente vacío', 900, '', 1000],
    ['cliente solo espacios', 900, '   ', 1000],
    ['peso 0', 900, 'Cliente', 0],
    ['peso -1', 900, 'Cliente', -1],
    ['peso 20001', 900, 'Cliente', 20001]
];

foreach ($invalidos as [$descripcion, $id, $cliente, $peso]) {
    esperarExcepcion(
        $descripcion,
        'InvalidArgumentException',
        fn () => new EnvioNormal($id, $cliente, $peso, EstadoEnvio::Pendiente)
    );
}

titulo('6.2 Cliente con espacios y tarifas límite');

$conEspacios = new EnvioNormal(900, '   Café   del   Puerto   ', 1000, EstadoEnvio::Pendiente);

comprobar(
    '"   Café   del   Puerto   " se guarda como "' . $conEspacios->cliente() . '"',
    $conEspacios->cliente() === 'Café   del   Puerto'
);

$limites = [
    [1, 470, 800],
    [1000, 470, 800],
    [1001, 590, 1000],
    [20000, 2750, 4600]
];

foreach ($limites as [$peso, $normalEsperada, $urgenteEsperada]) {
    $normal = new EnvioNormal(900, 'Prueba', $peso, EstadoEnvio::Pendiente);
    $urgente = new EnvioUrgente(901, 'Prueba', $peso, EstadoEnvio::Pendiente);

    comprobar(
        $peso . ' g → normal ' . $normal->tarifa() . ', urgente ' . $urgente->tarifa() . ' céntimos',
        $normal->tarifa() === $normalEsperada && $urgente->tarifa() === $urgenteEsperada
    );
}

comprobar('Los objetos de prueba no se han añadido al catálogo', count($repositorio->todos()) === 6);

titulo('6.2 Repositorio y servicio');

$original = $repositorio->buscar(101);

esperarExcepcion(
    'Registrar otro envío con id 101',
    'EnvioException',
    fn () => $repositorio->registrar(new EnvioUrgente(101, 'Duplicado', 300, EstadoEnvio::Pendiente))
);

comprobar('Se conserva la instancia anterior de 101', $repositorio->buscar(101) === $original);
comprobar('Siguen existiendo 6 envíos', count($repositorio->todos()) === 6);
comprobar('buscar(999) devuelve null', $repositorio->buscar(999) === null);

esperarExcepcion('buscar(0) en el repositorio', 'InvalidArgumentException', fn () => $repositorio->buscar(0));
esperarExcepcion('enviar(0) desde el servicio', 'InvalidArgumentException', fn () => $servicio->enviar(0));

comprobar(
    'El catálogo conserva sus 6 envíos en orden: ' . ids($repositorio->todos()),
    ids($repositorio->todos()) === '101, 102, 103, 104, 105, 106'
);

titulo('6.2 Consultas inválidas');

$vacio = new ServicioEnvios(new RepositorioEnviosMemoria());

$servicios = [
    ['catálogo', $servicio],
    ['repositorio vacío', $vacio]
];

foreach ($servicios as [$donde, $servicioPrueba]) {
    esperarExcepcion(
        "Modalidad 'aérea' (" . $donde . ')',
        'InvalidArgumentException',
        fn () => $servicioPrueba->consultar(modalidad: 'aérea')
    );

    esperarExcepcion(
        "Orden 'fecha' (" . $donde . ')',
        'InvalidArgumentException',
        fn () => $servicioPrueba->consultar(orden: 'fecha')
    );
}

esperarExcepcion(
    "Modalidad 'Normal' con mayúscula",
    'InvalidArgumentException',
    fn () => $servicio->consultar(modalidad: 'Normal')
);

esperarExcepcion('Orden vacío', 'InvalidArgumentException', fn () => $servicio->consultar(orden: ''));

comprobar('Una consulta válida en el repositorio vacío devuelve []', $vacio->consultar() === []);
comprobar('etiquetas([]) devuelve []', $servicio->etiquetas([]) === []);

echo '  resumir([]):' . PHP_EOL;
mostrarResumen($servicio->resumir([]));

comprobar(
    'resumir([]) devuelve las ocho claves a cero',
    $servicio->resumir([]) === [
        'cantidad' => 0, 'peso' => 0, 'importeTotal' => 0, 'importeActivo' => 0,
        'pendiente' => 0, 'enviado' => 0, 'entregado' => 0, 'cancelado' => 0
    ]
);
