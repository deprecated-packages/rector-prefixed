<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadCode\NodeManipulator;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
final class MagicMethodDetector
{
    /**
     * @var string[]
     */
    private const MAGIC_METHODS = ['__call', '__callStatic', '__clone', '__debugInfo', \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::DESCTRUCT, '__get', '__invoke', '__isset', '__set', \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::SET_STATE, '__sleep', '__toString', '__unset', '__wakeup'];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isMagicMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return $this->nodeNameResolver->isNames($classMethod, self::MAGIC_METHODS);
    }
}
