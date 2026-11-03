<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/datos/libros.php';

use Daniel\Biblioteca\Modelo\LibroDigital;
use Daniel\Biblioteca\Modelo\LibroPapel;
use Daniel\Biblioteca\Servicio\BibliotecaService;

function e(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$bibService = new BibliotecaService($libros);

$valores = [
    'tipo' => '',
    'titulo' => '',
    'autor' => '',
    'paginas' => '',
    'genero' => '',
    'unidades' => '',
    'fechaAlta' => '',
    'destacado' => false,
    'observaciones' => '',
    'correo' => ''
];

$errores = [];

$ficha = null;

$filas = [];
$resumen = [];

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$esPost = $metodo === 'POST';

if ($esPost) {
    foreach ($valores as $campo => $inicial) {
        if ($campo === 'destacado') {
            continue;
        }

        $entrada = $_POST[$campo] ?? '';

        if (!is_string($entrada)) {
            $errores[$campo] = 'El campo debe ser texto.';
            $entrada = '';
        }

        $valores[$campo] = trim($entrada);
    }

    if (!isset($errores['tipo']) && !in_array($valores['tipo'], ['papel', 'digital'], true)) {
        $errores['tipo'] = 'Elige papel o digital.';
    }

    if (!isset($errores['titulo'])) {
        if ($valores['titulo'] === '') {
            $errores['titulo'] = 'Escribe el título.';
        } elseif (mb_strlen($valores['titulo'], 'UTF-8') > 120) {
            $errores['titulo'] = 'El título admite hasta 120 caracteres.';
        }
    }

    if (!isset($errores['autor'])) {
        if ($valores['autor'] === '') {
            $errores['autor'] = 'Escribe el autor.';
        } elseif (mb_strlen($valores['autor'], 'UTF-8') > 100) {
            $errores['autor'] = 'El autor admite hasta 100 caracteres.';
        }
    }

    $paginas = filter_var($valores['paginas'], FILTER_VALIDATE_INT);
    if (!isset($errores['paginas']) && ($paginas === false || $paginas < 1 || $paginas > 3000)) {
        $errores['paginas'] = 'Escribe un número entero entre 1 y 3000.';
    }

    if (!isset($errores['genero']) && !in_array($valores['genero'], ['ciencia', 'fantasia', 'terror'], true)) {
        $errores['genero'] = 'Elige ciencia, fantasía o terror.';
    }

    $unidades = filter_var($valores['unidades'], FILTER_VALIDATE_INT);
    if (!isset($errores['unidades']) && ($unidades === false || $unidades < 1 || $unidades > 50)) {
        $errores['unidades'] = 'Escribe un número entero entre 1 y 50.';
    }

    $fechaAlta = null;
    if (!isset($errores['fechaAlta']) && $valores['fechaAlta'] !== '') {
        try {
            $fechaAlta = DateTimeImmutable::createFromFormat('!Y-m-d', $valores['fechaAlta']);
        } catch (ValueError) {
            $fechaAlta = false;
        }

        if ($fechaAlta === false || $fechaAlta->format('Y-m-d') !== $valores['fechaAlta']) {
            $errores['fechaAlta'] = 'Escribe una fecha válida con formato YYYY-MM-DD.';
            $fechaAlta = null;
        }
    }

    if (isset($_POST['destacado'])) {
        if ($_POST['destacado'] === '1') {
            $valores['destacado'] = true;
        } else {
            $errores['destacado'] = 'Valor de destacado no válido.';
            $valores['destacado'] = false;
        }
    }

    if (!isset($errores['observaciones']) && mb_strlen($valores['observaciones'], 'UTF-8') > 300) {
        $errores['observaciones'] = 'Las observaciones admiten hasta 300 caracteres.';
    }

    if (!isset($errores['correo'])) {
        if ($valores['correo'] === '') {
            $errores['correo'] = 'Escribe tu correo.';
        } elseif (filter_var($valores['correo'], FILTER_VALIDATE_EMAIL) === false) {
            $errores['correo'] = 'Escribe un correo válido.';
        }
    }

    if ($errores === []) {
        try {
            $clase = $valores['tipo'] === 'papel' ? LibroPapel::class : LibroDigital::class;

            $libro = new $clase(
                $valores['titulo'],
                $valores['autor'],
                $paginas,
                $valores['genero'],
                $unidades,
                $fechaAlta,
                $valores['destacado'],
                $valores['observaciones']
            );

            $bibService->agregar($libro);

            $ficha = $bibService->filas([$libro])[0];

            $filas = $bibService->filas($bibService->todos());
            $resumen = $bibService->resumen($bibService->todos());
        } catch (InvalidArgumentException $ex) {
            $errores['general'] = $ex->getMessage();
            $ficha = null;
        }
    }
}

require dirname(__DIR__) . '/vistas/alta.php';
