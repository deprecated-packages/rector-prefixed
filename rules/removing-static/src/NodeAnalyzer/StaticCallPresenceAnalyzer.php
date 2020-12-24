<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RemovingStatic\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function hasMethodStaticCallOnType(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, string $type) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($type) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
                return \false;
            }
            return $this->nodeTypeResolver->isObjectType($node->class, $type);
        });
    }
    public function hasClassAnyMethodWithStaticCallOnType(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, string $type) : bool
    {
        foreach ($class->getMethods() as $classMethod) {
            // handled else where
            if ((string) $classMethod->name === \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT) {
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
