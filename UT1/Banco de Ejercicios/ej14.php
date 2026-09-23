<?php

$texto = "PHP";
$i = 0;
while ($i < strlen($texto)) {
 if ($i === 1) {
 echo "-";
 }
 echo $texto[$i];
 $i++;
}

// Se imprimiría P-HP y el bucle se ejecutaria unas 3 veces.