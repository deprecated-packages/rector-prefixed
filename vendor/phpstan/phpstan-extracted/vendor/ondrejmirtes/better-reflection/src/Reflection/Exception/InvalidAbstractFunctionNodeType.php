<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception;

use InvalidArgumentException;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunctionAbstract;
use function get_class;
use function sprintf;
class InvalidAbstractFunctionNodeType extends \InvalidArgumentException
{
    public static function fromNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : self
    {
        return new self(\sprintf('Node for "%s" must be "%s" or "%s", was a "%s"', \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunctionAbstract::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike::class, \get_class($node)));
    }
}
