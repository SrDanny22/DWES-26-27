<?php

$busqueda = $_GET["q"] ?? "";

echo "Buscando: " . htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8');