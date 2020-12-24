<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Scope\NodeVisitor;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Nop;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Option;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider;
/**
 * Skips performance trap in PHPStan: https://github.com/phpstan/phpstan/issues/254
 */
final class RemoveDeepChainMethodCallNodeVisitor extends \_PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nestedChainMethodCallLimit = (int) $parameterProvider->provideParameter(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::NESTED_CHAIN_METHOD_CALL_LIMIT);
    }
    public function enterNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?int
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if ($node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall && $node->expr->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            $nestedChainMethodCalls = $this->betterNodeFinder->findInstanceOf([$node->expr], \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class);
            if (\count($nestedChainMethodCalls) > $this->nestedChainMethodCallLimit) {
                $this->removingExpression = $node;
                return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
            }
        }
        return null;
    }
    /**
     * @return Nop|Node
     */
    public function leaveNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node)
    {
        if ($node === $this->removingExpression) {
            // keep any node, so we don't remove it permanently
            $nop = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Nop();
            $nop->setAttributes($node->getAttributes());
            return $nop;
        }
        return $node;
    }
}
