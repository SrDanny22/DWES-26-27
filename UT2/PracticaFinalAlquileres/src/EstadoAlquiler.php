<?php

declare(strict_types=1);

enum EstadoAlquiler: string {
    case Reservado = 'reservado';
    case Activo = 'activo';
    case Finalizado = 'finalizado';
}