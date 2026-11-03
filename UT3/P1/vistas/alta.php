<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de libro</title>
</head>
<body>
    <h1>Alta de libro</h1>

<?php if ($ficha === null): ?>
    <?php if (isset($errores['general'])): ?>
        <p><strong><?= e($errores['general']) ?></strong></p>
    <?php endif; ?>

    <form action="alta.php" method="post">
        <p>
            <label for="tipo">Tipo de libro</label>
            <select name="tipo" id="tipo">
                <option value=""></option>
                <option value="papel" <?= $valores['tipo'] === 'papel' ? 'selected' : '' ?>>Papel</option>
                <option value="digital" <?= $valores['tipo'] === 'digital' ? 'selected' : '' ?>>Digital</option>
            </select>
            <?php if (isset($errores['tipo'])): ?>
                <span><?= e($errores['tipo']) ?></span>
            <?php endif; ?>
        </p>

        <p>
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" value="<?= e($valores['titulo']) ?>">
            <?php if (isset($errores['titulo'])): ?>
                <span><?= e($errores['titulo']) ?></span>
            <?php endif; ?>
        </p>

        <p>
            <label for="autor">Autor</label>
            <input type="text" id="autor" name="autor" value="<?= e($valores['autor']) ?>">
            <?php if (isset($errores['autor'])): ?>
                <span><?= e($errores['autor']) ?></span>
            <?php endif; ?>
        </p>

        <p>
            <label for="paginas">Páginas</label>
            <input type="text" id="paginas" name="paginas" value="<?= e($valores['paginas']) ?>">
            <?php if (isset($errores['paginas'])): ?>
                <span><?= e($errores['paginas']) ?></span>
            <?php endif; ?>
        </p>

        <p>
            <label for="genero">Género</label>
            <select name="genero" id="genero">
                <option value=""></option>
                <option value="ciencia" <?= $valores['genero'] === 'ciencia' ? 'selected' : '' ?>>Ciencia</option>
                <option value="fantasia" <?= $valores['genero'] === 'fantasia' ? 'selected' : '' ?>>Fantasía</option>
                <option value="terror" <?= $valores['genero'] === 'terror' ? 'selected' : '' ?>>Terror</option>
            </select>
            <?php if (isset($errores['genero'])): ?>
                <span><?= e($errores['genero']) ?></span>
            <?php endif; ?>
        </p>

        <p>
            <label for="unidades">Ejemplares o licencias</label>
            <input type="text" id="unidades" name="unidades" value="<?= e($valores['unidades']) ?>">
            <?php if (isset($errores['unidades'])): ?>
                <span><?= e($errores['unidades']) ?></span>
            <?php endif; ?>
        </p>

        <p>
            <label for="fechaAlta">Fecha de alta</label>
            <input type="text" id="fechaAlta" name="fechaAlta" placeholder="YYYY-MM-DD" value="<?= e($valores['fechaAlta']) ?>">
            <?php if (isset($errores['fechaAlta'])): ?>
                <span><?= e($errores['fechaAlta']) ?></span>
            <?php endif; ?>
        </p>

        <p>
            <label for="destacado">Destacado</label>
            <input type="checkbox" name="destacado" id="destacado" value="1" <?= $valores['destacado'] ? 'checked' : '' ?>>
            <?php if (isset($errores['destacado'])): ?>
                <span><?= e($errores['destacado']) ?></span>
            <?php endif; ?>
        </p>

        <p>
            <label for="observaciones">Observaciones</label>
            <textarea name="observaciones" id="observaciones"><?= e($valores['observaciones']) ?></textarea>
            <?php if (isset($errores['observaciones'])): ?>
                <span><?= e($errores['observaciones']) ?></span>
            <?php endif; ?>
        </p>

        <p>
            <label for="correo">Correo</label>
            <input type="text" id="correo" name="correo" value="<?= e($valores['correo']) ?>">
            <?php if (isset($errores['correo'])): ?>
                <span><?= e($errores['correo']) ?></span>
            <?php endif; ?>
        </p>

        <button type="submit">Dar de alta</button>
    </form>

<?php else: ?>
    <p>Libro dado de alta correctamente por <?= e($valores['correo']) ?>.</p>

    <h2>Ficha del libro</h2>
    <ul>
        <li>Título: <?= e($ficha['titulo']) ?></li>
        <li>Autor: <?= e($ficha['autor']) ?></li>
        <li>Tipo: <?= e(ucfirst($ficha['tipo'])) ?></li>
        <li>Género: <?= e($ficha['genero']) ?></li>
        <li>Páginas: <?= $ficha['paginas'] ?></li>
        <li>Unidades: <?= $ficha['unidades'] ?></li>
        <li>Fecha: <?= e($ficha['fechaAlta']) ?></li>
        <li>Destacado: <?= $ficha['destacado'] ? 'Sí' : 'No' ?></li>
        <li>Observaciones: <?= $ficha['observaciones'] === '' ? 'Sin observaciones' : e($ficha['observaciones']) ?></li>
        <li>Coste: <?= number_format($ficha['costeCentimos'] / 100, 2, ',', '.') ?> €</li>
    </ul>

    <h2>Catálogo</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Género</th>
                <th>Tipo</th>
                <th>Páginas</th>
                <th>Unidades</th>
                <th>Coste de reposición</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filas as $fila): ?>
                <tr>
                    <td><?= e($fila['titulo']) ?></td>
                    <td><?= e($fila['autor']) ?></td>
                    <td><?= e($fila['genero']) ?></td>
                    <td><?= e(ucfirst($fila['tipo'])) ?></td>
                    <td><?= $fila['paginas'] ?></td>
                    <td><?= $fila['unidades'] ?></td>
                    <td><?= number_format($fila['costeCentimos'] / 100, 2, ',', '.') ?> €</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Resumen</h2>
    <h3>Número de títulos</h3>
    <p><?= $resumen['titulos'] ?></p>
    <h3>Unidades</h3>
    <p><?= $resumen['unidades'] ?></p>
    <h3>Páginas</h3>
    <p><?= $resumen['paginas'] ?></p>
    <h3>Coste total</h3>
    <p><?= number_format($resumen['costeCentimos'] / 100, 2, ',', '.') ?> €</p>
<?php endif; ?>

    <p><a href="index.php">Volver al catálogo</a></p>
</body>
</html>
