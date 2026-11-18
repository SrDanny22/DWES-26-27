<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/archivos.php';

$anterior = null;

if (array_key_exists('anterior', $_GET)) {
    $anterior = $_GET['anterior'];
    if (!is_string($anterior) || mimeCartel($anterior) === false) {
        http_response_code(404);
        require __DIR__ . '/../vistas/no-encontrado.php';
        exit;
    }
}

$errores = [];
$mensaje = null;
$guardado = null;

$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    if (postExcesivo()) {
        $errores['imagen'] = 'El envío completo supera el límite de 8 MiB que admite PHP.';
    } else {
        $recepcion = recibirImagen($_FILES);

        if ($recepcion['error'] !== null) {
            $errores['imagen'] = $recepcion['error'];
        } elseif ($recepcion['archivo'] === null) {
            if ($anterior === null) {
                $errores['imagen'] = 'Selecciona una imagen.';
            } else {
                $mensaje = 'No se ha cambiado el cartel.';
            }
        } else {
            $archivo = $recepcion['archivo'];
            $validacion = validarImagen($archivo);

            if ($validacion['error'] !== null) {
                $errores['imagen'] = $validacion['error'];
            } else {
                try {
                    $destino = prepararDestino($validacion['extension'], $anterior);

                    if (!move_uploaded_file($archivo['tmp_name'], $destino['ruta'])) {
                        $errores['imagen'] = 'No se ha podido guardar la imagen.';
                    } elseif ($anterior === null) {
                        $guardado = $destino['nombre'];
                        $mensaje = 'Cartel guardado.';
                    } elseif (retirarCartel($anterior)) {
                        $guardado = $destino['nombre'];
                        $mensaje = 'Cartel sustituido.';
                    } else {
                        $errores['general'] = 'No se ha podido retirar el cartel anterior, así que la sustitución no se ha completado y se conserva el cartel actual.';

                        if (retirarCartel($destino['nombre'])) {
                            $errores['general'] .= ' La imagen nueva se ha retirado.';
                        } else {
                            error_log('No se ha podido retirar el cartel nuevo ' . $destino['nombre'] . ' tras una sustitución fallida.');
                            $errores['general'] .= ' No se ha podido retirar la imagen nueva.';
                        }
                    }
                } catch (RuntimeException $error) {
                    $errores['imagen'] = $error->getMessage();
                }
            }
        }
    }
}

require __DIR__ . '/../vistas/subir.php';
