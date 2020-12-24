<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan;

abstract class AnalysedCodeException extends \Exception
{
    public abstract function getTip() : ?string;
}
