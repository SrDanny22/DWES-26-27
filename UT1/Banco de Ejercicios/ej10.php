<?php

$retraso = 0;

if ($retraso > 30) {
    echo "Bloqueo temporal";
} elseif ($retraso >= 8 && $retraso <= 30) {
    echo "Retraso grave";
} elseif ($retraso >= 1 && $retraso <= 7) {
    echo "Retraso leve";
} else {
    echo "Sin retraso";
}
