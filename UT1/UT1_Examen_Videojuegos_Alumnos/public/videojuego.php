<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/funciones.php';
require_once __DIR__ . '/../src/datos.php';


$id = $_GET['id'] ?? 0;

$idInt = (int) $id;

$videojuego = buscarPorId($videojuegos, $idInt);

if ($videojuego === null) {

?>
    <!doctype html>
    <html lang="es">

    <head>
        <meta charset="utf-8">
        <title>Videojuego no encontrado</title>
    </head>

    <body>
        <p>No existe ningun videojuego con el id <?= $idInt ?>.</p>
        <a href="public/index.php">Volver al catálogo</a>
    </body>

    </html>
<?php
    exit;
}

// Prepara las fechas y los valores que necesita la ficha.
$fechaLanzamiento = new DateTimeImmutable($videojuego['fechaLanzamiento']); // De dónde saco la fecha??
$hoy = new DateTimeImmutable('today');
$diasTranscurridos = $hoy->diff($fechaLanzamiento)->days;
// Faltaba esto
$finNovedad = $fechaLanzamiento->modify('+30 days');
// Cálculo de estado para decidir si es novedad o catálogo
$estado = '';

// COMPLETAR los cálculos anteriores utilizando los datos del videojuego.
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Ficha del videojuego</title>
</head>

<body>
    <h1><?= htmlspecialchars($videojuego['titulo'] ?? '') ?></h1>

    <dl>
        <dt>Estudio</dt>
        <dd><?= htmlspecialchars($videojuego['estudio'] ?? '') ?></dd>

        <dt>Género</dt>
        <dd><?= htmlspecialchars($videojuego['genero'] ?? '') ?></dd>

        <dt>Plataforma</dt>
        <dd><?= htmlspecialchars($videojuego['plataforma'] ?? '') ?></dd>

        <dt>Precio</dt>
        <dd>
            <?php if ($videojuego !== null): ?>
                <?= number_format($videojuego['precio'], 2, ',', '.') ?> €
            <?php endif; ?>
        </dd>

        <dt>Puntuación</dt>
        <dd><?= $videojuego['puntuacion'] ?? '' ?></dd>

        <dt>Fecha de lanzamiento</dt>
        <dd><?= $fechaLanzamiento->format('d/m/Y') ?></dd>

        <dt>Días desde el lanzamiento</dt>
        <dd><?= $diasTranscurridos ?></dd>

        <dt>Fin del periodo de novedad</dt>
        <dd><!-- COMPLETAR --></dd>

        <dt>Estado</dt>
        <dd><!-- COMPLETAR --></dd>
    </dl>

    <p><a href="index.php">Volver al catálogo</a></p>
</body>

</html>