<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Laravel\Rector\Assign;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Laravel\NodeFactory\AppAssignFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\Laravel\ValueObject\ServiceNameTypeAndVariableName;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Laravel\Tests\Rector\Assign\CallOnAppArrayAccessToStandaloneAssignRector\CallOnAppArrayAccessToStandaloneAssignRectorTest
 */
final class CallOnAppArrayAccessToStandaloneAssignRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ServiceNameTypeAndVariableName[]
     */
    private $serviceNameTypeAndVariableNames = [];
    /**
     * @var AppAssignFactory
     */
    private $appAssignFactory;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Laravel\NodeFactory\AppAssignFactory $appAssignFactory)
    {
        $this->serviceNameTypeAndVariableNames[] = new \_PhpScoper2a4e7ab1ecbc\Rector\Laravel\ValueObject\ServiceNameTypeAndVariableName('validator', '_PhpScoper2a4e7ab1ecbc\\Illuminate\\Validation\\Factory', 'validationFactory');
        $this->appAssignFactory = $appAssignFactory;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        $methodCall = $node->expr;
        if (!$this->isObjectType($methodCall->var, '_PhpScoper2a4e7ab1ecbc\\Illuminate\\Contracts\\Foundation\\Application')) {
            return null;
        }
        if (!$methodCall->var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch) {
            return null;
        }
        $arrayDimFetchDim = $methodCall->var->dim;
        if ($arrayDimFetchDim === null) {
            return null;
        }
        foreach ($this->serviceNameTypeAndVariableNames as $serviceNameTypeAndVariableName) {
            if (!$this->isValue($arrayDimFetchDim, $serviceNameTypeAndVariableName->getServiceName())) {
                continue;
            }
            $assignExpression = $this->appAssignFactory->createAssignExpression($serviceNameTypeAndVariableName, $methodCall->var);
            $this->addNodeBeforeNode($assignExpression, $node);
            $methodCall->var = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable($serviceNameTypeAndVariableName->getVariableName());
            return $node;
        }
        return null;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace magical call on $this->app["something"] to standalone type assign variable', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application
     */
    private $app;

    public function run()
    {
        $validator = $this->app['validator']->make('...');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application
     */
    private $app;

    public function run()
    {
        /** @var \Illuminate\Validation\Factory $validationFactory */
        $validationFactory = $this->app['validator'];
        $validator = $validationFactory->make('...');
    }
}
CODE_SAMPLE
)]);
    }
}
