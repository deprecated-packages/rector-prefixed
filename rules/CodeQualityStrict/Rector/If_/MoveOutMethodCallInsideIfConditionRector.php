<?php

declare (strict_types=1);
namespace Rector\CodeQualityStrict\Rector\If_;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\If_;
use PHPStan\Analyser\Scope;
use PHPStan\Type\BooleanType;
use PHPStan\Type\ThisType;
use Rector\CodeQuality\Naming\MethodCallToVariableNameResolver;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\CodeQualityStrict\Rector\If_\MoveOutMethodCallInsideIfConditionRector\MoveOutMethodCallInsideIfConditionRectorTest
 */
final class MoveOutMethodCallInsideIfConditionRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var MethodCallToVariableNameResolver
     */
    private $methodCallToVariableNameResolver;
    /**
     * @param \Rector\CodeQuality\Naming\MethodCallToVariableNameResolver $methodCallToVariableNameResolver
     */
    public function __construct($methodCallToVariableNameResolver)
    {
        $this->methodCallToVariableNameResolver = $methodCallToVariableNameResolver;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move out method call inside If condition', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
if ($obj->run($arg) === 1) {

}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$objRun = $obj->run($arg);
if ($objRun === 1) {

}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        /** @var MethodCall[] $methodCalls */
        $methodCalls = $this->betterNodeFinder->findInstanceOf($node->cond, \PhpParser\Node\Expr\MethodCall::class);
        $countMethodCalls = \count($methodCalls);
        // No method call or Multiple method calls inside if → skip
        if ($countMethodCalls !== 1) {
            return null;
        }
        $methodCall = $methodCalls[0];
        if ($this->shouldSkipMethodCall($methodCall)) {
            return null;
        }
        return $this->moveOutMethodCall($methodCall, $node);
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    private function shouldSkipMethodCall($methodCall) : bool
    {
        $variableType = $this->getStaticType($methodCall->var);
        // From PropertyFetch → skip
        if ($variableType instanceof \PHPStan\Type\ThisType) {
            return \true;
        }
        $methodCallReturnType = $this->getStaticType($methodCall);
        if ($methodCallReturnType instanceof \PHPStan\Type\BooleanType) {
            return \true;
        }
        // No Args → skip
        if ($methodCall->args === []) {
            return \true;
        }
        // Inside Method calls args has Method Call again → skip
        return $this->isInsideMethodCallHasMethodCall($methodCall);
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     * @param \PhpParser\Node\Stmt\If_ $if
     */
    private function moveOutMethodCall($methodCall, $if) : ?\PhpParser\Node\Stmt\If_
    {
        $hasParentAssign = (bool) $this->betterNodeFinder->findParentType($methodCall, \PhpParser\Node\Expr\Assign::class);
        if ($hasParentAssign) {
            return null;
        }
        $variableName = $this->methodCallToVariableNameResolver->resolveVariableName($methodCall);
        if ($variableName === null) {
            return null;
        }
        if ($this->isVariableNameAlreadyDefined($if, $variableName)) {
            return null;
        }
        $variable = new \PhpParser\Node\Expr\Variable($variableName);
        $methodCallAssign = new \PhpParser\Node\Expr\Assign($variable, $methodCall);
        $this->addNodebeforeNode($methodCallAssign, $if);
        // replace if cond with variable
        if ($if->cond === $methodCall) {
            $if->cond = $variable;
            return $if;
        }
        // replace method call with variable
        $this->traverseNodesWithCallable($if->cond, function (\PhpParser\Node $node) use($variable) : ?Variable {
            if ($node instanceof \PhpParser\Node\Expr\MethodCall) {
                return $variable;
            }
            return null;
        });
        return $if;
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    private function isInsideMethodCallHasMethodCall($methodCall) : bool
    {
        foreach ($methodCall->args as $arg) {
            if ($arg->value instanceof \PhpParser\Node\Expr\MethodCall) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param \PhpParser\Node\Stmt\If_ $if
     * @param string $variableName
     */
    private function isVariableNameAlreadyDefined($if, $variableName) : bool
    {
        /** @var Scope $scope */
        $scope = $if->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        return $scope->hasVariableType($variableName)->yes();
    }
}
