<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan;

final class ShouldNotHappenException extends \Exception
{
    public function __construct(string $message = 'Internal error.')
    {
        parent::__construct($message);
    }
}
