<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Roave\BetterReflection\SourceLocator\Type\Composer\Factory\Exception;

use InvalidArgumentException;
use function sprintf;
final class InvalidProjectDirectory extends \InvalidArgumentException implements \_PhpScoperabd03f0baf05\Roave\BetterReflection\SourceLocator\Type\Composer\Factory\Exception\Exception
{
    public static function atPath(string $path) : self
    {
        return new self(\sprintf('Could not locate project directory "%s"', $path));
    }
}
