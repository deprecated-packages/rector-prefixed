<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\PrettyPrinter\Standard;
use RuntimeException;
use function sprintf;
use function substr;
class InvalidConstantNode extends \RuntimeException
{
    public static function create(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : self
    {
        return new self(\sprintf('Invalid constant node (first 50 characters: %s)', \substr((new \_PhpScoper0a6b37af0871\PhpParser\PrettyPrinter\Standard())->prettyPrint([$node]), 0, 50)));
    }
}
