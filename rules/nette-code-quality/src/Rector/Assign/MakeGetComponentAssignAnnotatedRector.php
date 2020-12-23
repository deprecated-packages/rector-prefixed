<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\Rector\Assign;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocManipulator\VarAnnotationManipulator;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector\MakeGetComponentAssignAnnotatedRectorTest
 */
final class MakeGetComponentAssignAnnotatedRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var VarAnnotationManipulator
     */
    private $varAnnotationManipulator;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocManipulator\VarAnnotationManipulator $varAnnotationManipulator)
    {
        $this->varAnnotationManipulator = $varAnnotationManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add doc type for magic $control->getComponent(...) assign', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->isGetComponentMethodCallOrArrayDimFetchOnControl($node->expr)) {
            return null;
        }
        if (!$node->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            return null;
        }
        $variableName = $this->getName($node->var);
        if ($variableName === null) {
            return null;
        }
        $nodeVar = $this->getObjectType($node->var);
        if (!$nodeVar instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            return null;
        }
        $controlType = $this->resolveControlType($node);
        if (!$controlType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
            return null;
        }
        $this->varAnnotationManipulator->decorateNodeWithInlineVarType($node, $controlType, $variableName);
        return $node;
    }
    private function isGetComponentMethodCallOrArrayDimFetchOnControl(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : bool
    {
        if ($this->isOnClassMethodCall($expr, '_PhpScoper0a2ac50786fa\\Nette\\Application\\UI\\Control', 'getComponent')) {
            return \true;
        }
        return $this->isArrayDimFetchStringOnControlVariable($expr);
    }
    private function resolveControlType(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign $assign) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($assign->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            /** @var MethodCall $methodCall */
            $methodCall = $assign->expr;
            return $this->resolveCreateComponentMethodCallReturnType($methodCall);
        }
        if ($assign->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch) {
            /** @var ArrayDimFetch $arrayDimFetch */
            $arrayDimFetch = $assign->expr;
            return $this->resolveArrayDimFetchControlType($arrayDimFetch);
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
    }
    private function isArrayDimFetchStringOnControlVariable(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch) {
            return \false;
        }
        if (!$expr->dim instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_) {
            return \false;
        }
        $varStaticType = $this->getStaticType($expr->var);
        if (!$varStaticType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        return \is_a($varStaticType->getClassName(), '_PhpScoper0a2ac50786fa\\Nette\\Application\\UI\\Control', \true);
    }
    private function resolveCreateComponentMethodCallReturnType(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        /** @var Scope|null $scope */
        $scope = $methodCall->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
        }
        if (\count((array) $methodCall->args) !== 1) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
        }
        $firstArgumentValue = $methodCall->args[0]->value;
        if (!$firstArgumentValue instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
        }
        return $this->resolveTypeFromShortControlNameAndVariable($firstArgumentValue, $scope, $methodCall->var);
    }
    private function resolveArrayDimFetchControlType(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        /** @var Scope|null $scope */
        $scope = $arrayDimFetch->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $this->resolveTypeFromShortControlNameAndVariable($arrayDimFetch->dim, $scope, $arrayDimFetch->var);
    }
    private function resolveTypeFromShortControlNameAndVariable(\_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_ $shortControlString, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $componentName = $this->getValue($shortControlString);
        $methodName = \sprintf('createComponent%s', \ucfirst($componentName));
        $calledOnType = $scope->getType($expr);
        if (!$calledOnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
        }
        if (!$calledOnType->hasMethod($methodName)->yes()) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
        }
        // has method
        $method = $calledOnType->getMethod($methodName, $scope);
        return \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants())->getReturnType();
    }
}
