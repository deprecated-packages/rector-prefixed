<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception;

use InvalidArgumentException;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunctionAbstract;
use function get_class;
use function sprintf;
class InvalidAbstractFunctionNodeType extends \InvalidArgumentException
{
    public static function fromNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : self
    {
        return new self(\sprintf('Node for "%s" must be "%s" or "%s", was a "%s"', \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunctionAbstract::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike::class, \get_class($node)));
    }
}
