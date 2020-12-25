<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\Rector\Assign;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use Rector\BetterPhpDocParser\PhpDocManipulator\VarAnnotationManipulator;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\MakeGetComponentAssignAnnotatedRectorTest
 */
final class MakeGetComponentAssignAnnotatedRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var VarAnnotationManipulator
     */
    private $varAnnotationManipulator;
    public function __construct(\Rector\BetterPhpDocParser\PhpDocManipulator\VarAnnotationManipulator $varAnnotationManipulator)
    {
        $this->varAnnotationManipulator = $varAnnotationManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add doc type for magic $control->getComponent(...) assign', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Nette\Application\UI\Control;

final class SomeClass
{
    public function run()
    {
        $externalControl = new ExternalControl();
        $anotherControl = $externalControl->getComponent('another');
    }
}

final class ExternalControl extends Control
{
    public function createComponentAnother(): AnotherControl
    {
        return new AnotherControl();
    }
}

final class AnotherControl extends Control
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Nette\Application\UI\Control;

final class SomeClass
{
    public function run()
    {
        $externalControl = new ExternalControl();
        /** @var AnotherControl $anotherControl */
        $anotherControl = $externalControl->getComponent('another');
    }
}

final class ExternalControl extends Control
{
    public function createComponentAnother(): AnotherControl
    {
        return new AnotherControl();
    }
}

final class AnotherControl extends Control
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isGetComponentMethodCallOrArrayDimFetchOnControl($node->expr)) {
            return null;
        }
        if (!$node->var instanceof \PhpParser\Node\Expr\Variable) {
            return null;
        }
        $variableName = $this->getName($node->var);
        if ($variableName === null) {
            return null;
        }
        $nodeVar = $this->getObjectType($node->var);
        if (!$nodeVar instanceof \PHPStan\Type\MixedType) {
            return null;
        }
        $controlType = $this->resolveControlType($node);
        if (!$controlType instanceof \PHPStan\Type\TypeWithClassName) {
            return null;
        }
        $this->varAnnotationManipulator->decorateNodeWithInlineVarType($node, $controlType, $variableName);
        return $node;
    }
    private function isGetComponentMethodCallOrArrayDimFetchOnControl(\PhpParser\Node\Expr $expr) : bool
    {
        if ($this->isOnClassMethodCall($expr, '_PhpScoper17db12703726\\Nette\\Application\\UI\\Control', 'getComponent')) {
            return \true;
        }
        return $this->isArrayDimFetchStringOnControlVariable($expr);
    }
    private function resolveControlType(\PhpParser\Node\Expr\Assign $assign) : \PHPStan\Type\Type
    {
        if ($assign->expr instanceof \PhpParser\Node\Expr\MethodCall) {
            /** @var MethodCall $methodCall */
            $methodCall = $assign->expr;
            return $this->resolveCreateComponentMethodCallReturnType($methodCall);
        }
        if ($assign->expr instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            /** @var ArrayDimFetch $arrayDimFetch */
            $arrayDimFetch = $assign->expr;
            return $this->resolveArrayDimFetchControlType($arrayDimFetch);
        }
        return new \PHPStan\Type\MixedType();
    }
    private function isArrayDimFetchStringOnControlVariable(\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            return \false;
        }
        if (!$expr->dim instanceof \PhpParser\Node\Scalar\String_) {
            return \false;
        }
        $varStaticType = $this->getStaticType($expr->var);
        if (!$varStaticType instanceof \PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        return \is_a($varStaticType->getClassName(), '_PhpScoper17db12703726\\Nette\\Application\\UI\\Control', \true);
    }
    private function resolveCreateComponentMethodCallReturnType(\PhpParser\Node\Expr\MethodCall $methodCall) : \PHPStan\Type\Type
    {
        /** @var Scope|null $scope */
        $scope = $methodCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return new \PHPStan\Type\MixedType();
        }
        if (\count($methodCall->args) !== 1) {
            return new \PHPStan\Type\MixedType();
        }
        $firstArgumentValue = $methodCall->args[0]->value;
        if (!$firstArgumentValue instanceof \PhpParser\Node\Scalar\String_) {
            return new \PHPStan\Type\MixedType();
        }
        return $this->resolveTypeFromShortControlNameAndVariable($firstArgumentValue, $scope, $methodCall->var);
    }
    private function resolveArrayDimFetchControlType(\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : \PHPStan\Type\Type
    {
        /** @var Scope|null $scope */
        $scope = $arrayDimFetch->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        return $this->resolveTypeFromShortControlNameAndVariable($arrayDimFetch->dim, $scope, $arrayDimFetch->var);
    }
    private function resolveTypeFromShortControlNameAndVariable(\PhpParser\Node\Scalar\String_ $shortControlString, \PHPStan\Analyser\Scope $scope, \PhpParser\Node\Expr $expr) : \PHPStan\Type\Type
    {
        $componentName = $this->getValue($shortControlString);
        $methodName = \sprintf('createComponent%s', \ucfirst($componentName));
        $calledOnType = $scope->getType($expr);
        if (!$calledOnType instanceof \PHPStan\Type\TypeWithClassName) {
            return new \PHPStan\Type\MixedType();
        }
        if (!$calledOnType->hasMethod($methodName)->yes()) {
            return new \PHPStan\Type\MixedType();
        }
        // has method
        $method = $calledOnType->getMethod($methodName, $scope);
        return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants())->getReturnType();
    }
}
