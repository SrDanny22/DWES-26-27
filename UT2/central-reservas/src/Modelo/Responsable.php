<?php
declare(strict_types=1);

// M4. Responsable final con propiedades readonly.
final class Responsable
{
    use GeneraEtiqueta;

    public function __construct(
        public readonly int $id,
        public readonly string $nombre
    ) {
        if ($id <= 0) {
            throw new InvalidArgumentException('El id del responsable debe ser positivo.');
        }
        if (trim($nombre) === '') {
            throw new InvalidArgumentException('El nombre del responsable no puede estar vacío.');
        }
    }

    public function id(): int
    {
        return $this->id;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }
}
