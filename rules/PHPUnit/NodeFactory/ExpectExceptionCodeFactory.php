<?php

declare (strict_types=1);
namespace Rector\PHPUnit\NodeFactory;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use Rector\NodeNameResolver\NodeNameResolver;
final class ExpectExceptionCodeFactory
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ArgumentShiftingFactory
     */
    private $argumentShiftingFactory;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\PHPUnit\NodeFactory\ArgumentShiftingFactory $argumentShiftingFactory)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->argumentShiftingFactory = $argumentShiftingFactory;
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
        // looking for "$exception->getMessage()"
        if (!$this->nodeNameResolver->areNamesEqual($secondArgument->var, $exceptionVariable)) {
            return null;
        }
        if (!$this->nodeNameResolver->isName($secondArgument->name, 'getCode')) {
            return null;
        }
        return $this->argumentShiftingFactory->createFromMethodCall($methodCall, 'expectExceptionCode');
    }
}
