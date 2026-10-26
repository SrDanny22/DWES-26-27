<?php

declare(strict_types=1);

require_once __DIR__ . '/Autor.php';

$autor = new Autor('Frank Herbert', 'AUT-01');

// nombre es readonly: al reasignarlo PHP lanza Error
$autor->nombre = 'Otro autor';
