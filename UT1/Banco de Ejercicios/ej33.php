<?php

$busqueda = $_GET["q"] ?? "";

echo htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8');