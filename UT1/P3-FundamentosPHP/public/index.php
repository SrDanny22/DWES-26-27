<?php

// Para que el tipado sea estricto.
declare(strict_types=1);

// Constantes que usaremos a lo largo del código.
const DIAS_ALUMNO = 15;
const DIAS_PROFESOR = 30;
const DIAS_EXTERNO = 7;

const DIAS_RENOVACION = 7;

const RETRASO_LEVE = 5;
const RETRASO_GRAVE = 10;

const PENALIZACION_POR_DIA = 0.50;

const MAX_LINEAS = 10;

// Leemos los párametros y de damos un valor por defecto.
$tipo = $_GET['tipo'] ?? 'externo';

$diasPara = $_GET['dias'] ?? 0;

$renovacion = $_GET['renovacion'] ?? 'no';

// Convertimos todo en minuscula y sin espacios por si ponen Alumno o SI.
$tipo = strtolower(trim($tipo));
$renovacion = strtolower(trim($renovacion));

// Arrays para darle valor a los valores previstos
$tiposValidos = ['alumno', 'profesor', 'externo'];
$renovacionValida = ['si', 'no'];

// Comprobamos que los valores si no son los previstos, que ponga el valor a externo y que la renovacion si pone otra cosa, que sea no.
if (!in_array($tipo, $tiposValidos, true)) {
    $tipo = 'externo';
}

if (!in_array($renovacion, $renovacionValida, true)) {
    $renovacion = 'no';
}

// Convertimos a entero la variable dias.
$dias = (int) $diasPara;

// Con esta condicion, nos aseguramos que si pone un valor negatico, pondra el valor por defecto a 0.
if ($dias < 0) {
    $dias = 0;
}

// Asignamos el valor dependiendo el tipo que sea.
$diasPrestamo = match ($tipo) {
    'alumno' => DIAS_ALUMNO,
    'profesor' => DIAS_PROFESOR,
    'externo' => DIAS_EXTERNO,
    default => DIAS_EXTERNO,
};

// Añadimos 7 días mas a los que tienen renovación excepto los que son externos.
if ($renovacion === 'si' && $tipo !== 'externo') {
    $diasPrestamo += DIAS_RENOVACION;
}

// Sacamos el retraso cogiendo los dias y restadoles el limite.
$retraso = $dias - $diasPrestamo;

// Clasificamos la situacion dependiendo del retraso que tienen.
if ($retraso < 0) {
    $situacion = 'correcta';
} elseif ($retraso === 0) {
    $situacion = 'último día';
} elseif ($retraso <= RETRASO_LEVE) {
    $situacion = 'retraso leve';
} else {
    $situacion = 'retraso grave';
}

// Aqui hacemos que los que tengan retraso
if ($retraso > 0) {
    $diasRetraso = $retraso;
} else {
    $diasRetraso = 0;
}

// Aqui calculamos la penalizacion segun los dias que tenga de retraso.
$penalizacion = $diasRetraso * PENALIZACION_POR_DIA;

// Al ser parametros externos que le pasamos por la URL, es peligroso si no usamos el htmlspecialchars, 
// que lo que hace es convertir caracteres especiales en entidades HTML para evitar que el navegador los interprete como código, 
// del párametro dias no es necesario hacerlo porque al parsearlo a int, solo recoge numeros y nada de texto. 
$tipoSeguro = htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8');
$renovacionSeguro = htmlspecialchars($renovacion, ENT_QUOTES, 'UTF-8');

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Condiciones de préstamo</title>
</head>
<body>
    <h1>Condiciones del préstamo</h1>
    <!-- Aqui mostramos los datos del préstamo. -->
    <ul>
        <li>Tipo de usuairo: <?= $tipoSeguro ?></li>
        <li>Días de prestamo: <?= $dias ?></li>
        <li>Renovación: <?= $renovacionSeguro ?></li>
        <li>Límite de días permitido: <?= $diasPrestamo ?></li>
    </ul>

    <?php
    // Aqui formamos la frase que pide el ejercicio.
    $frase = "Usuario de tipo '" . $tipoSeguro . "' tiene " . $dias . " día(s) de préstamo, con un límite de " . $diasPrestamo . " día(s). Su situación es de: " . $situacion . ". Y con una penalización de " . $penalizacion . "€";
    ?>

    <p><?= $frase ?></p>

    <?php
    // Aqui comprobamos si los dias de retraso son mas que 0 para hacer el for, si no lo son, dejamos un mensaje diciendo que no hay nada que listar. 
    if ($diasRetraso > 0) {
        echo "<h2>Lista de días de retraso</h2>";
        echo "<ul>";

        // Como el maximo de lineas permitidas son 10, para hacer el for, compruebo que si los dias de retraso se pasan de 10,
        // hago que la variable lienasAMostrar valga 10, y si no se pasa de 10, que lineasAMostrar valga lo mismo que los días de retraso.
        if ($diasRetraso > MAX_LINEAS) {
            $lineasAMostrar = MAX_LINEAS;
        } else {
            $lineasAMostrar = $diasRetraso;
        }

        // Aqui hago el for donde a i por cada recorrido que hace, se le aplique la penalización
        for ($i = 1; $i <= $lineasAMostrar; $i++) {
            echo "<li>Día " . $i . " de retraso, penalización de: " . ($i * PENALIZACION_POR_DIA) . "€</li>";
        }

        // Si los dias de retraso son mas de 10, hacemos que muestre los ... .
        if ($diasRetraso > MAX_LINEAS) {
            echo "<li>...</li>";
        }

        echo "</ul>";

    } else {
        echo "<p>Sin días de retraso que listar.</p>";
    }
    ?>
</body>
</html>