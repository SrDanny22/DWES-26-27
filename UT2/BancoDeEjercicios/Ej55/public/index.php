<?php

declare(strict_types=1);

use App\Model\Libro;
use App\Service\CatalogoService;

require __DIR__ . '/../vendor/autoload.php';

/*
 * Fallos que aparecían al ejecutar, en orden:
 *
 * 1. Class "App\Model\Libro" not found
 *    El archivo estaba en src/libro.php. Por PSR-4, App\Model\Libro tiene que estar en src/Model/Libro.php
 *    (con la carpeta Model y la L mayúscula). Se movió el archivo.
 *
 * 2. Class "App\Service\CatalogoService" not found
 *    El archivo src/Service/CatalogoService.php declaraba namespace App\Services. Se corrigió a App\Service.
 *
 * 3. TypeError: mostrar() must be of type App\Service\Libro, App\Model\Libro given
 *    El servicio usaba Libro sin importarlo, así que PHP buscaba App\Service\Libro.
 *    Se añadió use App\Model\Libro; en el servicio.
 */

$dune = new Libro('Dune');
$solaris = new Libro('Solaris');

$servicio = new CatalogoService();

echo $servicio->mostrar($dune) . PHP_EOL;
echo $servicio->mostrar($solaris) . PHP_EOL;
