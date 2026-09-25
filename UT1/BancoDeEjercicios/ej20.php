<?php

$paginas = [22, 554, 297, 412, 112, 1032, 777, 616];

sort($paginas);
$suma = 0;
foreach ($paginas as $pagina) {
    $suma += $pagina;
}
echo "Minimo: $paginas[0] <br>";
echo "Maximo:" . $paginas[count($paginas) -1] . "<br>";
echo "Media: " . ($suma / count($paginas));