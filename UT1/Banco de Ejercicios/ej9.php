<?php

$titulo = " El nombre del viento ";

$titulo = trim($titulo);
$longitud = strlen($titulo);

$contieneViento = str_contains($titulo, "viento");

$titulo = str_replace("viento", "fuego", $titulo);

$palabras = explode(" ", $titulo);