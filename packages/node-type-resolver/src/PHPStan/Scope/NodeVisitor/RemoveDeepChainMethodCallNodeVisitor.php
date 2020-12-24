<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Scope\NodeVisitor;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Nop;
use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract;
use _PhpScoper0a6b37af0871\Rector\Core\Configuration\Option;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider;
/**
 * Skips performance trap in PHPStan: https://github.com/phpstan/phpstan/issues/254
 */
final class RemoveDeepChainMethodCallNodeVisitor extends \_PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nestedChainMethodCallLimit = (int) $parameterProvider->provideParameter(\_PhpScoper0a6b37af0871\Rector\Core\Configuration\Option::NESTED_CHAIN_METHOD_CALL_LIMIT);
    }
    public function enterNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?int
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if ($node->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall && $node->expr->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            $nestedChainMethodCalls = $this->betterNodeFinder->findInstanceOf([$node->expr], \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class);
            if (\count($nestedChainMethodCalls) > $this->nestedChainMethodCallLimit) {
                $this->removingExpression = $node;
                return \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
            }
        }
        return null;
    }
    /**
     * @return Nop|Node
     */
    public function leaveNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node)
    {
        if ($node === $this->removingExpression) {
            // keep any node, so we don't remove it permanently
            $nop = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Nop();
            $nop->setAttributes($node->getAttributes());
            return $nop;
        }
        return $node;
    }
}
