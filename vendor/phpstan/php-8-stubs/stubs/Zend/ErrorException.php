<?php

namespace _PhpScopera143bcca66cb;

class ErrorException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, int $severity = \E_ERROR, ?string $filename = null, ?int $line = null, ?\Throwable $previous = null)
    {
    }
    public final function getSeverity() : int
    {
    }
}
\class_alias('_PhpScopera143bcca66cb\\ErrorException', 'ErrorException', \false);
