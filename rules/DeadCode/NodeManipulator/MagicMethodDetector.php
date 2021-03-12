<?php

declare (strict_types=1);
namespace Rector\DeadCode\NodeManipulator;

use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\ValueObject\MethodName;
use Rector\NodeNameResolver\NodeNameResolver;
final class MagicMethodDetector
{
    /**
     * @var string[]
     */
    private const MAGIC_METHODS = ['__call', '__callStatic', \Rector\Core\ValueObject\MethodName::CLONE, '__debugInfo', \Rector\Core\ValueObject\MethodName::DESCTRUCT, '__get', '__invoke', '__isset', '__set', \Rector\Core\ValueObject\MethodName::SET_STATE, '__sleep', '__toString', '__unset', '__wakeup'];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isMagicMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return $this->nodeNameResolver->isNames($classMethod, self::MAGIC_METHODS);
    }
}
