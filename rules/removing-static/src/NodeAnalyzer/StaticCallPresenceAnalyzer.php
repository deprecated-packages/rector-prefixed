<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\RemovingStatic\NodeAnalyzer;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver;
final class StaticCallPresenceAnalyzer
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function hasMethodStaticCallOnType(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, string $type) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use($type) : bool {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall) {
                return \false;
            }
            return $this->nodeTypeResolver->isObjectType($node->class, $type);
        });
    }
    public function hasClassAnyMethodWithStaticCallOnType(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, string $type) : bool
    {
        foreach ($class->getMethods() as $classMethod) {
            // handled else where
            if ((string) $classMethod->name === \_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::CONSTRUCT) {
                continue;
            }
            $hasStaticCall = $this->hasMethodStaticCallOnType($classMethod, $type);
            if ($hasStaticCall) {
                return \true;
            }
        }
        return \false;
    }
}
