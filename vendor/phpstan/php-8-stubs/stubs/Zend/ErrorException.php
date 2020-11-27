<?php

namespace _PhpScoperbd5d0c5f7638;

class ErrorException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, int $severity = \E_ERROR, ?string $filename = null, ?int $line = null, ?\Throwable $previous = null)
    {
    }
    public final function getSeverity() : int
    {
    }
}
\class_alias('_PhpScoperbd5d0c5f7638\\ErrorException', 'ErrorException', \false);
