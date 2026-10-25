<?php

declare(strict_types=1);

trait TieneFechaCreacion {
    private string $fechaCreacion;

    private function inicializarFechaCreacion(string $fecha): void {
        $this->fechaCreacion = $fecha;
    }

    public function fechaCreacion(): string {
        return $this->fechaCreacion;
    }

    public function etiquetaCreacion(): string {
        return 'Creado el ' . $this->fechaCreacion;
    }
}
