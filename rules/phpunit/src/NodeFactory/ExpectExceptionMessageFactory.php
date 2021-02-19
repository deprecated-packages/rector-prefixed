<?php

declare (strict_types=1);
namespace Rector\PHPUnit\NodeFactory;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use Rector\Core\PhpParser\Comparing\NodeComparator;
use Rector\NodeNameResolver\NodeNameResolver;
final class ExpectExceptionMessageFactory
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeComparator
     */
    private $nodeComparator;
    /**
     * @var ArgumentShiftingFactory
     */
    private $argumentShiftingFactory;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\PHPUnit\NodeFactory\ArgumentShiftingFactory $argumentShiftingFactory, \Rector\Core\PhpParser\Comparing\NodeComparator $nodeComparator)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->argumentShiftingFactory = $argumentShiftingFactory;
        $this->nodeComparator = $nodeComparator;
    }
    public function create(\PhpParser\Node\Expr\MethodCall $methodCall, \PhpParser\Node\Expr\Variable $exceptionVariable) : ?\PhpParser\Node\Expr\MethodCall
    {
        if (!$this->nodeNameResolver->isLocalMethodCallsNamed($methodCall, ['assertSame', 'assertEquals'])) {
            return null;
        }
        $secondArgument = $methodCall->args[1]->value;
        if (!$secondArgument instanceof \PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        if (!$this->nodeComparator->areNodesEqual($secondArgument->var, $exceptionVariable)) {
            return null;
        }
        if (!$this->nodeNameResolver->isName($secondArgument->name, 'getMessage')) {
            return null;
        }
        return $this->argumentShiftingFactory->createFromMethodCall($methodCall, 'expectExceptionMessage');
    }
}
