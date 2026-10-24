<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/cargar.php';
require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';

$actividades = crearActividades();
$avisos = [];
$mensaje = '';
$error = '';
$cierre = '';

// INICIO E1
// Todas las entradas se leen con entrada(): un array usa su valor por defecto.
$texto = entrada($_GET, 'q');

$tipo = entrada($_GET, 'tipo');
if (!in_array($tipo, ['', 'gratuita', 'pago'], true)) {
    $avisos[] = 'El tipo indicado no es válido; se muestran todos los tipos.';
    $tipo = '';
}

$estadoTexto = entrada($_GET, 'estado');
$estado = null;
if ($estadoTexto !== '') {
    $estado = EstadoActividad::tryFrom($estadoTexto);
    if ($estado === null) {
        $avisos[] = 'El estado indicado no es válido; se muestran todos los estados.';
        $estadoTexto = '';
    }
}

$soloDisponibles = entrada($_GET, 'disponibles') === '1';

$orden = entrada($_GET, 'orden', 'nombre');
if (!in_array($orden, ['nombre', 'libres'], true)) {
    $orden = 'nombre';
}

$idConsulta = entrada($_GET, 'id');
// FIN E1

if (isset($_GET['accion'])) {
    // INICIO E2
    try {
        $accion = entrada($_GET, 'accion');
        if (!in_array($accion, ['reservar', 'cancelar'], true)) {
            throw new InvalidArgumentException('Acción no válida.');
        }

        $idActividad = enteroPositivo(entrada($_GET, 'idActividad'));
        $cantidad = enteroPositivo(entrada($_GET, 'cantidad'));

        // Se busca en el catálogo completo, aunque los filtros oculten la actividad.
        $actividad = buscarPorId($actividades, $idActividad);
        if ($actividad === null) {
            throw new ReservaException('No existe la actividad indicada.');
        }

        if ($accion === 'reservar') {
            $actividad->reservar($cantidad);
            $realizada = 'Reserva realizada';
        } else {
            $actividad->cancelar($cantidad);
            $realizada = 'Cancelación realizada';
        }

        $mensaje = $realizada . '. Importe: ' . euros($actividad->importe($cantidad));
    } catch (PlazasInsuficientesException $excepcion) {
        $error = 'Plazas insuficientes: ' . $excepcion->getMessage();
    } catch (ReservaException $excepcion) {
        $error = 'Operación rechazada: ' . $excepcion->getMessage();
    } catch (InvalidArgumentException $excepcion) {
        $error = 'Entrada no válida: ' . $excepcion->getMessage();
    } finally {
        $cierre = 'Procesamiento de la operación finalizado.';
    }
    // FIN E2
}

// INICIO E3
$ficha = null;
if ($idConsulta !== '') {
    try {
        $ficha = buscarPorId($actividades, enteroPositivo($idConsulta));
        if ($ficha === null) {
            $avisos[] = 'No existe la actividad de la ficha.';
        }
    } catch (InvalidArgumentException) {
        $avisos[] = 'El id de la ficha debe ser un entero positivo.';
    }
}

$visibles = ordenarActividades(
    filtrarActividades($actividades, $texto, $tipo, $estado, $soloDisponibles),
    $orden
);
$resumen = resumirActividades($visibles);
$etiquetas = generarEtiquetas($visibles, prefijo: 'Actividad: ');
// FIN E3

require __DIR__ . '/../vista/catalogo.php';
