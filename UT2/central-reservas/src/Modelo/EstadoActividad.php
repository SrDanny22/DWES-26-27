<?php
declare(strict_types=1);

// M2. Estado de una actividad, respaldado por string.
enum EstadoActividad: string
{
    case Abierta = 'abierta';
    case Cerrada = 'cerrada';
}
