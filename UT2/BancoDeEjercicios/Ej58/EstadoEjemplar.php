<?php

declare(strict_types=1);

enum EstadoEjemplar: string {
    case Disponible = 'disponible';
    case Prestado = 'prestado';
    case Perdido = 'perdido';
}
