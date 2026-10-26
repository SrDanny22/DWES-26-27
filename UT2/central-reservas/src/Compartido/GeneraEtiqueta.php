<?php
declare(strict_types=1);

// M3. Trait compartido por Actividad y Responsable.
trait GeneraEtiqueta
{
    public function etiqueta(string $prefijo = ''): string
    {
        // Limpia los extremos y reduce los grupos de espacios a uno (u = UTF-8).
        $nombre = preg_replace('/\s+/u', ' ', trim($this->nombre())) ?? '';

        return $prefijo . $this->id() . ' · ' . $nombre;
    }
}
