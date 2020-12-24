<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Node;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\Constant\ClassConstantFetch;
use _PhpScopere8e811afab72\PHPStan\Node\Property\PropertyRead;
use _PhpScopere8e811afab72\PHPStan\Node\Property\PropertyWrite;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
class ClassStatementsGatherer
{
    /** @var ClassReflection */
    private $classReflection;
    /** @var callable(\PhpParser\Node $node, Scope $scope): void */
    private $nodeCallback;
    /** @var ClassPropertyNode[] */
    private $properties = [];
    /** @var \PhpParser\Node\Stmt\ClassMethod[] */
    private $methods = [];
    /** @var \PHPStan\Node\Method\MethodCall[] */
    private $methodCalls = [];
    /** @var array<int, PropertyWrite|PropertyRead> */
    private $propertyUsages = [];
    /** @var \PhpParser\Node\Stmt\ClassConst[] */
    private $constants = [];
    /** @var ClassConstantFetch[] */
    private $constantFetches = [];
    /**
     * @param ClassReflection $classReflection
     * @param callable(\PhpParser\Node $node, Scope $scope): void $nodeCallback
     */
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, callable $nodeCallback)
    {
        $this->classReflection = $classReflection;
        $this->nodeCallback = $nodeCallback;
    }
    /**
     * @return ClassPropertyNode[]
     */
    public function getProperties() : array
    {
        return $this->properties;
    }
    /**
     * @return \PhpParser\Node\Stmt\ClassMethod[]
     */
    public function getMethods() : array
    {
        return $this->methods;
    }
    /**
     * @return Method\MethodCall[]
     */
    public function getMethodCalls() : array
    {
        return $this->methodCalls;
    }
    /**
     * @return array<int, PropertyWrite|PropertyRead>
     */
    public function getPropertyUsages() : array
    {
        return $this->propertyUsages;
    }
    /**
     * @return \PhpParser\Node\Stmt\ClassConst[]
     */
    public function getConstants() : array
    {
        return $this->constants;
    }
    /**
     * @return ClassConstantFetch[]
     */
    public function getConstantFetches() : array
    {
        return $this->constantFetches;
    }
    public function __invoke(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : void
    {
        $nodeCallback = $this->nodeCallback;
        $nodeCallback($node, $scope);
        $this->gatherNodes($node, $scope);
    }
    private function gatherNodes(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : void
    {
        if (!$scope->isInClass()) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        if ($scope->getClassReflection()->getName() !== $this->classReflection->getName()) {
            return;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PHPStan\Node\ClassPropertyNode && !$scope->isInTrait()) {
            $this->properties[] = $node;
            if ($node->isPromoted()) {
                $this->propertyUsages[] = new \_PhpScopere8e811afab72\PHPStan\Node\Property\PropertyWrite(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($node->getName())), $scope);
            }
            return;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod && !$scope->isInTrait()) {
            $this->methods[] = $node;
            return;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst) {
            $this->constants[] = $node;
            return;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            $this->methodCalls[] = new \_PhpScopere8e811afab72\PHPStan\Node\Method\MethodCall($node, $scope);
            return;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_ && \count($node->items) === 2) {
            $this->methodCalls[] = new \_PhpScopere8e811afab72\PHPStan\Node\Method\MethodCall($node, $scope);
            return;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch) {
            $this->constantFetches[] = new \_PhpScopere8e811afab72\PHPStan\Node\Constant\ClassConstantFetch($node, $scope);
            return;
        }
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
            return;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Coalesce) {
            $this->gatherNodes($node->var, $scope);
            return;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\EncapsedStringPart) {
            return;
        }
        $inAssign = $scope->isInExpressionAssign($node);
        while ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            $node = $node->var;
        }
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch && !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch) {
            return;
        }
        if ($inAssign) {
            $this->propertyUsages[] = new \_PhpScopere8e811afab72\PHPStan\Node\Property\PropertyWrite($node, $scope);
        } else {
            $this->propertyUsages[] = new \_PhpScopere8e811afab72\PHPStan\Node\Property\PropertyRead($node, $scope);
        }
    }
}
