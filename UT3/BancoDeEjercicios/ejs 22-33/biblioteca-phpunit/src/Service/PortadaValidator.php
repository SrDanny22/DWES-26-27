<?php
declare(strict_types=1);
namespace App\Service;
final class PortadaValidator
{
    private const TAMANO_MAXIMO = 2 * 1024 * 1024;
    private const MIME_PERMITIDOS = ['image/jpeg', 'image/png', 'image/webp'];

    public function validar(int $tamano, string $mime): ?string
    {
        if ($tamano < 1 || $tamano > self::TAMANO_MAXIMO) {
            return 'La portada debe ocupar entre 1 byte y 2 MiB.';
        }
        if (!in_array($mime, self::MIME_PERMITIDOS, true)) {
            return 'La portada debe ser una imagen JPEG, PNG o WebP.';
        }
        return null;
    }
}
