<?php

namespace _PhpScoper88fe6e0ad041;

class ErrorException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, int $severity = \E_ERROR, ?string $filename = null, ?int $line = null, ?\Throwable $previous = null)
    {
    }
    public final function getSeverity() : int
    {
    }
}
\class_alias('_PhpScoper88fe6e0ad041\\ErrorException', 'ErrorException', \false);
