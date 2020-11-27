<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\Type\Composer\Factory\Exception;

use InvalidArgumentException;
use function sprintf;
final class InvalidProjectDirectory extends \InvalidArgumentException implements \_PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\Type\Composer\Factory\Exception\Exception
{
    public static function atPath(string $path) : self
    {
        return new self(\sprintf('Could not locate project directory "%s"', $path));
    }
}
