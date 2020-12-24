<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan;

final class ShouldNotHappenException extends \Exception
{
    public function __construct(string $message = 'Internal error.')
    {
        parent::__construct($message);
    }
}
