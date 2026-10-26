<?php
declare(strict_types=1);

// M7. Especialización final gratuita. Usa el constructor heredado.
final class ActividadGratuita extends Actividad
{
    public function tipo(): string
    {
        return 'gratuita';
    }

    public function importe(int $cantidad): int
    {
        if ($cantidad < 0) {
            throw new InvalidArgumentException('La cantidad no puede ser negativa.');
        }

        return 0;
    }
}
