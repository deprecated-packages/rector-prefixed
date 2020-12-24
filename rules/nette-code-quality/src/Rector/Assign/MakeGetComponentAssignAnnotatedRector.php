<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Rector\Assign;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocManipulator\VarAnnotationManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\MakeGetComponentAssignAnnotatedRectorTest
 */
final class MakeGetComponentAssignAnnotatedRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var VarAnnotationManipulator
     */
    private $varAnnotationManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocManipulator\VarAnnotationManipulator $varAnnotationManipulator)
    {
        $this->varAnnotationManipulator = $varAnnotationManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add doc type for magic $control->getComponent(...) assign', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isGetComponentMethodCallOrArrayDimFetchOnControl($node->expr)) {
            return null;
        }
        if (!$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return null;
        }
        $variableName = $this->getName($node->var);
        if ($variableName === null) {
            return null;
        }
        $nodeVar = $this->getObjectType($node->var);
        if (!$nodeVar instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return null;
        }
        $controlType = $this->resolveControlType($node);
        if (!$controlType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return null;
        }
        $this->varAnnotationManipulator->decorateNodeWithInlineVarType($node, $controlType, $variableName);
        return $node;
    }
    private function isGetComponentMethodCallOrArrayDimFetchOnControl(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        if ($this->isOnClassMethodCall($expr, '_PhpScoperb75b35f52b74\\Nette\\Application\\UI\\Control', 'getComponent')) {
            return \true;
        }
        return $this->isArrayDimFetchStringOnControlVariable($expr);
    }
    private function resolveControlType(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($assign->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            /** @var MethodCall $methodCall */
            $methodCall = $assign->expr;
            return $this->resolveCreateComponentMethodCallReturnType($methodCall);
        }
        if ($assign->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch) {
            /** @var ArrayDimFetch $arrayDimFetch */
            $arrayDimFetch = $assign->expr;
            return $this->resolveArrayDimFetchControlType($arrayDimFetch);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
    private function isArrayDimFetchStringOnControlVariable(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch) {
            return \false;
        }
        if (!$expr->dim instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
            return \false;
        }
        $varStaticType = $this->getStaticType($expr->var);
        if (!$varStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        return \is_a($varStaticType->getClassName(), '_PhpScoperb75b35f52b74\\Nette\\Application\\UI\\Control', \true);
    }
    private function resolveCreateComponentMethodCallReturnType(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        /** @var Scope|null $scope */
        $scope = $methodCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        if (\count((array) $methodCall->args) !== 1) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        $firstArgumentValue = $methodCall->args[0]->value;
        if (!$firstArgumentValue instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        return $this->resolveTypeFromShortControlNameAndVariable($firstArgumentValue, $scope, $methodCall->var);
    }
    private function resolveArrayDimFetchControlType(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        /** @var Scope|null $scope */
        $scope = $arrayDimFetch->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $this->resolveTypeFromShortControlNameAndVariable($arrayDimFetch->dim, $scope, $arrayDimFetch->var);
    }
    private function resolveTypeFromShortControlNameAndVariable(\_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_ $shortControlString, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $componentName = $this->getValue($shortControlString);
        $methodName = \sprintf('createComponent%s', \ucfirst($componentName));
        $calledOnType = $scope->getType($expr);
        if (!$calledOnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        if (!$calledOnType->hasMethod($methodName)->yes()) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        // has method
        $method = $calledOnType->getMethod($methodName, $scope);
        return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants())->getReturnType();
    }
}
