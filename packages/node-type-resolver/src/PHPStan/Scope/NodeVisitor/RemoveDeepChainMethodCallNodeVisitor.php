<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Scope\NodeVisitor;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Nop;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider;
/**
 * Skips performance trap in PHPStan: https://github.com/phpstan/phpstan/issues/254
 */
final class RemoveDeepChainMethodCallNodeVisitor extends \_PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract
{
    /**
     * @var int
     */
    private $nestedChainMethodCallLimit;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var Expression|null
     */
    private $removingExpression;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nestedChainMethodCallLimit = (int) $parameterProvider->provideParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::NESTED_CHAIN_METHOD_CALL_LIMIT);
    }
    public function enterNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?int
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if ($node->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall && $node->expr->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            $nestedChainMethodCalls = $this->betterNodeFinder->findInstanceOf([$node->expr], \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class);
            if (\count($nestedChainMethodCalls) > $this->nestedChainMethodCallLimit) {
                $this->removingExpression = $node;
                return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
            }
        }
        return null;
    }
    /**
     * @return Nop|Node
     */
    public function leaveNode(\_PhpScopere8e811afab72\PhpParser\Node $node)
    {
        if ($node === $this->removingExpression) {
            // keep any node, so we don't remove it permanently
            $nop = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Nop();
            $nop->setAttributes($node->getAttributes());
            return $nop;
        }
        return $node;
    }
}
