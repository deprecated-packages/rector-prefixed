<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class LetManipulator
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isLetNeededInClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        foreach ($class->getMethods() as $classMethod) {
            // new test
            if ($this->nodeNameResolver->isName($classMethod, 'test*')) {
                continue;
            }
            $hasBeConstructedThrough = (bool) $this->betterNodeFinder->find((array) $classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : ?bool {
                if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
                    return null;
                }
                return $this->nodeNameResolver->isName($node->name, 'beConstructedThrough');
            });
            if ($hasBeConstructedThrough) {
                continue;
            }
            return \true;
        }
        return \false;
    }
}
