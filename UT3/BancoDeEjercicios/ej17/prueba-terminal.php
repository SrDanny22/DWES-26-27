<?php

declare(strict_types=1);

require __DIR__ . '/config/portadas.php';

$temporal = tempnam(sys_get_temp_dir(), 'portada');
file_put_contents($temporal, base64_decode(PNG_EJEMPLO));

$destino = DIRECTORIO_PORTADAS . '/' . bin2hex(random_bytes(16)) . '.png';
$movido = move_uploaded_file($temporal, $destino);

echo 'El archivo temporal existe: ' . (is_file($temporal) ? 'sí' : 'no') . PHP_EOL;
echo 'MIME detectado: ' . detectarMime($temporal) . PHP_EOL;
echo 'move_uploaded_file devuelve: ' . var_export($movido, true) . PHP_EOL;
echo 'El archivo no llegó en una subida HTTP de esta petición, así que move_uploaded_file lo rechaza.' . PHP_EOL;

unlink($temporal);
