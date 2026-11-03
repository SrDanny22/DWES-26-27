<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 4</title>
</head>
<body>
    <form action="/ej04/libros.php" method="get">
        <label for="q">Título</label>
        <input id="q" name="q" type="text" value="<?= e($busqueda) ?>">
        <button type="submit">Buscar</button>
    </form>

    <?php if ($error !== ''): ?>
        <p><?= e($error) ?></p>
    <?php else: ?>
        <p>Búsqueda: <?= e($busqueda) ?></p>
    <?php endif; ?>
</body>
</html>
