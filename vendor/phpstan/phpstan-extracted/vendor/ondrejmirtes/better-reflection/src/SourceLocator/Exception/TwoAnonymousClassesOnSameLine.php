<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Exception;

use LogicException;
use function sprintf;
class TwoAnonymousClassesOnSameLine extends \LogicException
{
    public static function create(string $fileName, int $lineNumber) : self
    {
        return new self(\sprintf('Two anonymous classes on line %d in %s', $lineNumber, $fileName));
    }
}