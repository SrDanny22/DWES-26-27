<?php
use function \App\Soporte\e; ?>

<h2>Crear cuenta</h2>

<?php if ($error !== null): ?>
    <p><?= e($error) ?></p>
<?php endif; ?>

<form method="post">
    <label for="nombre">Nombre</label>
    <input id="nombre" name="nombre">
    <label for="emial">Correo</label>
    <input id="email" name="email">
    <label for="clave">Contraseña</label>
    <input type="password" name="clave" id="clave">
    <button>Crear cuenta</button>
</form>