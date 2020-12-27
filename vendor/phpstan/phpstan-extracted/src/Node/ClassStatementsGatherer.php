<?php

declare (strict_types=1);
namespace PHPStan\Node;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Node\Constant\ClassConstantFetch;
use PHPStan\Node\Property\PropertyRead;
use PHPStan\Node\Property\PropertyWrite;
use PHPStan\Reflection\ClassReflection;
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
    public function __construct(\PHPStan\Reflection\ClassReflection $classReflection, callable $nodeCallback)
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
    public function __invoke(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : void
    {
        $nodeCallback = $this->nodeCallback;
        $nodeCallback($node, $scope);
        $this->gatherNodes($node, $scope);
    }
    private function gatherNodes(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : void
    {
        if (!$scope->isInClass()) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        if ($scope->getClassReflection()->getName() !== $this->classReflection->getName()) {
            return;
        }
        if ($node instanceof \PHPStan\Node\ClassPropertyNode && !$scope->isInTrait()) {
            $this->properties[] = $node;
            if ($node->isPromoted()) {
                $this->propertyUsages[] = new \PHPStan\Node\Property\PropertyWrite(new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable('this'), new \PhpParser\Node\Identifier($node->getName())), $scope);
            }
            return;
        }
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod && !$scope->isInTrait()) {
            $this->methods[] = $node;
            return;
        }
        if ($node instanceof \PhpParser\Node\Stmt\ClassConst) {
            $this->constants[] = $node;
            return;
        }
        if ($node instanceof \PhpParser\Node\Expr\MethodCall || $node instanceof \PhpParser\Node\Expr\StaticCall) {
            $this->methodCalls[] = new \PHPStan\Node\Method\MethodCall($node, $scope);
            return;
        }
        if ($node instanceof \PhpParser\Node\Expr\Array_ && \count($node->items) === 2) {
            $this->methodCalls[] = new \PHPStan\Node\Method\MethodCall($node, $scope);
            return;
        }
        if ($node instanceof \PhpParser\Node\Expr\ClassConstFetch) {
            $this->constantFetches[] = new \PHPStan\Node\Constant\ClassConstantFetch($node, $scope);
            return;
        }
        if (!$node instanceof \PhpParser\Node\Expr) {
            return;
        }
        if ($node instanceof \PhpParser\Node\Expr\AssignOp\Coalesce) {
            $this->gatherNodes($node->var, $scope);
            return;
        }
        if ($node instanceof \PhpParser\Node\Scalar\EncapsedStringPart) {
            return;
        }
        $inAssign = $scope->isInExpressionAssign($node);
        while ($node instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            $node = $node->var;
        }
        if (!$node instanceof \PhpParser\Node\Expr\PropertyFetch && !$node instanceof \PhpParser\Node\Expr\StaticPropertyFetch) {
            return;
        }
        if ($inAssign) {
            $this->propertyUsages[] = new \PHPStan\Node\Property\PropertyWrite($node, $scope);
        } else {
            $this->propertyUsages[] = new \PHPStan\Node\Property\PropertyRead($node, $scope);
        }
    }
}
