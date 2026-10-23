<?php
declare(strict_types=1);

// TODO M4. Implementa la base abstracta Juego y las operaciones del préstamo.
abstract class Juego implements Prestable {
    use GeneraEtiqueta;

    private int $id;
    private string $nombre;
    private bool $prestado = false;
    private int $dias = 0;

    public function __construct(int $id, string $nombre) {
        if ($id <= 0) {
            throw new InvalidArgumentException('El id debe ser positivo.');
        }
        if (trim($nombre) === '') {
            throw new InvalidArgumentException('El nombre no puede estar vacío.');
        }

        $this->id = $id;
        $this->nombre = trim($nombre);
    }

    public function id(): int {
        return $this->id;
    }

    public function nombre(): string {
        return $this->nombre;
    }

    public function prestado(): bool {
        return $this->prestado;
    }

    public function dias(): int {
        return $this->dias;
    }

    abstract public function plazoMaximo(): int;

    public function ficha(): string {
        return $this->etiqueta() . ' · ' . ($this->prestado ? 'Prestado' : 'Disponible') . ' · Días: ' . $this->dias;
    }

    #[Override]
    public function prestar(int $dias): void
    {
        if ($dias <= 0) {
            throw new InvalidArgumentException('Días no puede ser 0 o menor que 0.');
        }

        if ($this->prestado) {
            throw new PrestamoException('Juego ya prestado.');
        }

        if ($dias > $this->plazoMaximo()) {
            throw new PrestamoException('Plazo máximo superado.');
        }

        $this->prestado = true;
        $this->dias = $dias;
    }

    #[Override]
    public function renovar(int $diasExtra): void
    {
        if ($diasExtra <= 0) {
            throw new InvalidArgumentException('Los días deben ser positivos.');
        }

        if (!$this->prestado) {
            throw new PrestamoException('El juego no está prestado.');
        }

        if ($this->dias + $diasExtra > $this->plazoMaximo()) {
            throw new PrestamoException('Plazo máximo superado.');
        }

        $this->dias += $diasExtra;
    }

    #[Override]
    public function devolver(): void
    {
        if (!$this->prestado) {
            throw new PrestamoException('El juego no esta prestado.');
        }
        $this->prestado = false;
        $this->dias = 0;
    }
}