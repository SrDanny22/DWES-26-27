<?php
$titulo = "El Quijote";
$autor = "Miguel de Cervantes";
$numPaginas = 512;
$precio = 22.9;
$disponibilidad = true;
$estado = $disponibilidad ? "Disponible" : "Agotado";

$mensaje = "El titulo del libro es " . $titulo . ", del autor " . $autor . ".Cuenta con " . $numPaginas . " páginas, cuesta un total de " . $precio . " y su estado es: " . $estado;

echo $mensaje;
