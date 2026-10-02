<?php

declare(strict_types=1);


// Importar librerías
require_once __DIR__ . '/../src/funciones.php';
require_once __DIR__ . '/../src/datos.php';

// Poner la zona horaria
date_default_timezone_set('Europe/Madrid');
// 3.1. Leer parámetros
$genero = $_GET['genero'] ?? 'todos';
$plataforma = $_GET['plataforma'] ?? 'todas';
$q = $_GET['q'] ?? '';
$orden = $_GET['orden'] ?? 'titulo';
// 3.2. Normalizar y comprobar que los valores recibidos estén dentro de los esperados

$genero = normalizarTexto($genero);
$plataforma = normalizarTexto($plataforma);
$q = normalizarTexto($q);
$orden = normalizarTexto($orden);

$generoSeguro = htmlspecialchars($genero, ENT_QUOTES, 'UTF-8');
$plataformaSeguro = htmlspecialchars($plataforma, ENT_QUOTES, 'UTF-8');
$qSeguro = htmlspecialchars($q, ENT_QUOTES, 'UTF-8');
$ordenSeguro = htmlspecialchars($orden, ENT_QUOTES, 'UTF-8');

// 3.3. Filtros
$resultados = $videojuegos;

// Aplica sobre $resultados los filtros, la búsqueda y la ordenación solicitados.
$filtrarGenero = filtrarPorPlataforma(filtrarPorGenero($resultados, $generoSeguro), $plataformaSeguro);

if ($qSeguro === "titulo" || $qSeguro === 'estudio') {
    $filtrarGenero = buscarPorTexto($filtrarGenero, $qSeguro);
}
// 3.5. Ordenar salida
// Ordena las dos colecciones anteriores manteniendo la relación entre claves y valores.
$filtrarGenero = ordenarVideojuegos($filtrarGenero, $orden);

$timestampConsulta = time();
$fechaConsulta = date('d/m/Y H:i', $timestampConsulta); // COMPLETAR
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Catálogo de videojuegos</title>
</head>
<body>
    <h1>Catálogo de videojuegos</h1>

    <form method="get">
        <label>
            Género:
            <input type="text" name="genero" value="<?= htmlspecialchars($generoSeguro) ?>">
        </label>

        <label>
            Plataforma:
            <select name="plataforma">
                <option value="todas">Todas</option>
                <?php foreach ($plataformas as $codigo => $nombre): ?>
                    <option value="<?= htmlspecialchars($codigo) ?>">
                        <?= htmlspecialchars($nombre) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            Buscar:
            <input type="text" name="q" value="<?= $qSeguro ?>">
        </label>

        <label>
            Orden:
            <select name="orden">
                <option value="titulo">Título</option>
                <option value="precio">Precio</option>
                <option value="puntuacion">Puntuación</option>
            </select>
        </label>

        <button type="submit">Aplicar</button>
    </form>

    <p>Resultados: <?= count($filtrarGenero) ?></p>

    <ul>
        <?php foreach ($filtrarGenero as $videojuego): ?>
            <li>
                <!-- Construye aquí el enlace a videojuego.php enviando su id. -->
                <?= htmlspecialchars($videojuego['titulo'])?>
                · <?= number_format($videojuego['precio'], 2, ',', '.') ?> €
                · <?= $videojuego['puntuacion'] ?>/10
                
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Plataformas por código</h2>
    <ul>
        <?php foreach ($plataformasOrdenadas as $codigo => $nombre): ?>
            <li><?= htmlspecialchars((string) $codigo) ?>: <?= htmlspecialchars((string) $nombre) ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Ventas de la semana</h2>
    <ul>
        <?php foreach ($ventasOrdenadas as $codigo => $ventas): ?>
            <li><?= htmlspecialchars((string) $codigo) ?>: <?= $ventas ?></li>
        <?php endforeach; ?>
    </ul>
    

    <p>Consulta generada: <?= htmlspecialchars($fechaConsulta) ?></p>
</body>
</html>
