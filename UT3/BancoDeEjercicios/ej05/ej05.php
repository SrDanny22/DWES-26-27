<?php

function e(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$titulo_original = ' <Dune> & "edición" '; 
$titulo_normalizado = trim($titulo_original); 
?>

<p><?php echo e($titulo_normalizado); ?></p>

<input name="titulo" value="<?php echo e($titulo_normalizado); ?>">
