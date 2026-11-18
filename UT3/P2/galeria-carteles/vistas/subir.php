<?php
$accion = $anterior === null ? 'subir.php' : 'subir.php?anterior=' . $anterior;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Subir cartel</title></head>
<body>
<h1>Subir cartel</h1>

<?php if ($guardado !== null): ?>
    <p><?= e($mensaje) ?></p>
    <img src="imagen.php?nombre=<?= e($guardado) ?>" alt="Cartel <?= e($guardado) ?>">
<?php else: ?>
    <?php if ($anterior !== null): ?>
        <img src="imagen.php?nombre=<?= e($anterior) ?>" alt="Cartel actual <?= e($anterior) ?>">
    <?php endif; ?>

    <?php if ($mensaje !== null): ?>
        <p><?= e($mensaje) ?></p>
    <?php endif; ?>

    <?php if (isset($errores['general'])): ?>
        <p><?= e($errores['general']) ?></p>
    <?php endif; ?>

    <form action="<?= e($accion) ?>" method="post" enctype="multipart/form-data">
        <label for="imagen">Imagen</label>
        <input type="file" id="imagen" name="imagen" accept="image/jpeg,image/png,image/webp">
        <?php if (isset($errores['imagen'])): ?>
            <span><?= e($errores['imagen']) ?></span>
        <?php endif; ?>
        <button type="submit">Guardar</button>
    </form>
<?php endif; ?>

<p><a href="index.php">Volver a la galería</a></p>
</body>
</html>
