<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/datos/libros.php';

use Daniel\Biblioteca\Servicio\BibliotecaService;

$bibService = new BibliotecaService($libros);


require_once dirname(__DIR__) . '/vistas/catalogo.php';
