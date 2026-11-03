<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 9</title>
</head>
<body>
    <h1>Contacto</h1>

    <h2>Variante con filter_input</h2>
    <form action="variante-input.php" method="post">
        <label for="email1">Correo</label>
        <input id="email1" name="email" type="text">
        <button type="submit">Enviar</button>
    </form>

    <h2>Variante con filter_var</h2>
    <form action="variante-var.php" method="post">
        <label for="email2">Correo</label>
        <input id="email2" name="email" type="text">
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
