<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Galería de carteles</title></head>
<body>
<h1>Galería de carteles</h1>
<p><a href="subir.php">Subir cartel</a></p>

<?php if ($errorGaleria !== null): ?>
    <p><?= e($errorGaleria) ?></p>
<?php elseif ($carteles === []): ?>
    <p>Todavía no hay carteles</p>
<?php else: ?>
    <ul>
        <?php foreach ($carteles as $cartel): ?>
            <li>
                <img src="imagen.php?nombre=<?= e($cartel) ?>" alt="Cartel <?= e($cartel) ?>">
                <p><?= e($cartel) ?></p>
                <p><a href="subir.php?anterior=<?= e($cartel) ?>">Sustituir</a></p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
</body>
</html>
