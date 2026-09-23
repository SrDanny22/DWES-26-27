<?php

$a = (5 == "5"); // a = true
$b = (5 === "5"); // b = false
$c = (10 > 5 && 3 < 2); // c = false
$d = !$b || $c; // d = true

// El == compara valores sin que tengan que ser del mismo tipo, el === es mas estricto y tienen que ser los valores del mismo tipo.
