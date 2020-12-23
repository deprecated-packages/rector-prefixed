<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\Rector\If_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ThisType;
use _PhpScoper0a2ac50786fa\Rector\CodeQuality\Naming\MethodCallToVariableNameResolver;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\If_\MoveOutMethodCallInsideIfConditionRector\MoveOutMethodCallInsideIfConditionRectorTest
 */
final class MoveOutMethodCallInsideIfConditionRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var MethodCallToVariableNameResolver
     */
    private $methodCallToVariableNameResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\CodeQuality\Naming\MethodCallToVariableNameResolver $methodCallToVariableNameResolver)
    {
        $this->methodCallToVariableNameResolver = $methodCallToVariableNameResolver;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move out method call inside If condition', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        /** @var MethodCall[] $methodCalls */
        $methodCalls = $this->betterNodeFinder->findInstanceOf($node->cond, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class);
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
    private function shouldSkipMethodCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $methodCallVar = $methodCall->var;
        $scope = $methodCallVar->getAttribute(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope::class);
        if ($scope === null) {
            return \true;
        }
        $type = $scope->getType($methodCallVar);
        // From PropertyFetch → skip
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ThisType) {
            return \true;
        }
        // Is Boolean return → skip
        $scope = $methodCall->getAttribute(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope::class);
        if ($scope === null) {
            return \true;
        }
        $type = $scope->getType($methodCall);
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType) {
            return \true;
        }
        // No Args → skip
        if ($methodCall->args === []) {
            return \true;
        }
        // Inside Method calls args has Method Call again → skip
        return $this->isInsideMethodCallHasMethodCall($methodCall);
    }
    private function moveOutMethodCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_
    {
        $variableName = $this->methodCallToVariableNameResolver->resolveVariableName($methodCall);
        if ($variableName === null) {
            return null;
        }
        if ($this->isVariableNameAlreadyDefined($if, $variableName)) {
            return null;
        }
        $variable = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable($variableName);
        $methodCallAssign = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign($variable, $methodCall);
        $this->addNodebeforeNode($methodCallAssign, $if);
        // replace if cond with variable
        if ($if->cond === $methodCall) {
            $if->cond = $variable;
            return $if;
        }
        // replace method call with variable
        $this->traverseNodesWithCallable($if->cond, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use($variable) : ?Variable {
            if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
                return $variable;
            }
            return null;
        });
        return $if;
    }
    private function isInsideMethodCallHasMethodCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        foreach ($methodCall->args as $arg) {
            if ($arg->value instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
                return \true;
            }
        }
        return \false;
    }
    private function isVariableNameAlreadyDefined(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if, string $variableName) : bool
    {
        /** @var Scope $scope */
        $scope = $if->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        return $scope->hasVariableType($variableName)->yes();
    }
}
