<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="alta.php" method="post">
        <p>
            <label for="tipo">Tipo de libro</label>
    
            <select name="tipo" id="tipo">
                <option value="">Todos</option>
                <option value="papel">Papel</option>
                <option value="digital">Digital</option>
            </select>
        </p>

        <p>
            <label for="titulo">Titulo</label>
            <input type="text" id="titulo" name="titulo" maxlength="120">
        </p>

        <p>
            <label for="autor">Autor</label>
            <input type="text" id="autor" name="autor" maxlength="100">
        </p>

        <p>
            <label for="paginas">Páginas</label>
            <input type="text" id="paginas" name="paginas" min="1" max="3000">
        </p>

        <p>
            <label for="genero">Género</label>

            <select name="genero" id="genero">
                <option value="">Todos</option>
                <option value="ciencia">Ciencia</option>
                <option value="fantasia">Fantasía</option>
                <option value="terror">Terror</option>
            </select>
        </p>

        <p>
            <label for="unidades">Unidades</label>
            <input type="text" id="unidades" name="unidades" min="1" max="50">
        </p>

        <p>
            <label for="fechaAlta">Fecha de Alta</label>
            <input type="text" id="fechaAlta" name="fechaAlta">
        </p>

        <p>
            <label for="destacados">Solo destacados</label>
            <input type="checkbox" name="destacados" id="destacados" value="1">
        </p>

        <p>
            <textarea name="oberservaciones"></textarea>
        </p>

        <p>
            <label for="correo">Correo</label>
            <input type="text" id="correo" name="correo required">
        </p>

    <button type="submit">Buscar</button>
    </form>
</body>
</html>