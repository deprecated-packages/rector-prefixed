<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan;

abstract class AnalysedCodeException extends \Exception
{
    public abstract function getTip() : ?string;
}
