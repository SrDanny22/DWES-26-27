<?php

declare(strict_types=1);

class Autor {
    public function __construct(public readonly string $nombre, public readonly string $codigo)
    {
        
    }
}