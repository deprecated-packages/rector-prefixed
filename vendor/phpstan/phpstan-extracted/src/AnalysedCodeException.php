<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan;

abstract class AnalysedCodeException extends \Exception
{
    public abstract function getTip() : ?string;
}
