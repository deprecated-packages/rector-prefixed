<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteKdyby\Naming;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Cast;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\NullsafeMethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Ternary;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Type\ThisType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException;
use _PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedYetException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
/**
 * @todo decouple to collector?
 */
final class VariableNaming
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->valueResolver = $valueResolver;
        $this->classNaming = $classNaming;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function resolveFromNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        $nodeType = $this->nodeTypeResolver->getStaticType($node);
        return $this->resolveFromNodeAndType($node, $nodeType);
    }
    public function resolveFromNodeAndType(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Type\Type $type) : ?string
    {
        $variableName = $this->resolveBareFromNode($node);
        if ($variableName === null) {
            return null;
        }
        // adjust static to specific class
        if ($variableName === 'this' && $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ThisType) {
            $shortClassName = $this->classNaming->getShortName($type->getClassName());
            $variableName = \lcfirst($shortClassName);
        }
        return \_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::underscoreToCamelCase($variableName);
    }
    public function resolveFromNodeWithScopeCountAndFallbackName(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, string $fallbackName) : string
    {
        $name = $this->resolveFromNode($expr);
        if ($name === null) {
            $name = $fallbackName;
        }
        return \lcfirst($this->createCountedValueName($name, $scope));
    }
    public function createCountedValueName(string $valueName, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : string
    {
        if ($scope === null) {
            return $valueName;
        }
        // make sure variable name is unique
        if (!$scope->hasVariableType($valueName)->yes()) {
            return $valueName;
        }
        // we need to add number suffix until the variable is unique
        $i = 2;
        $countedValueNamePart = $valueName;
        while ($scope->hasVariableType($valueName)->yes()) {
            $valueName = $countedValueNamePart . $i;
            ++$i;
        }
        return $valueName;
    }
    public function resolveFromFuncCallFirstArgumentWithSuffix(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall, string $suffix, string $fallbackName, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : string
    {
        $bareName = $this->resolveBareFuncCallArgumentName($funcCall, $fallbackName, $suffix);
        return $this->createCountedValueName($bareName, $scope);
    }
    private function resolveBareFromNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        $node = $this->unwrapNode($node);
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            return $this->resolveParamNameFromArrayDimFetch($node);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return $this->resolveFromPropertyFetch($node);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\NullsafeMethodCall || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            return $this->resolveFromMethodCall($node);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_) {
            return $this->resolveFromNew($node);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            return $this->resolveFromNode($node->name);
        }
        if ($node === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException();
        }
        $paramName = $this->nodeNameResolver->getName($node);
        if ($paramName !== null) {
            return $paramName;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return $node->value;
        }
        return null;
    }
    private function resolveBareFuncCallArgumentName(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall, string $fallbackName, string $suffix) : string
    {
        $argumentValue = $funcCall->args[0]->value;
        if ($argumentValue instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall || $argumentValue instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            $name = $this->nodeNameResolver->getName($argumentValue->name);
        } else {
            $name = $this->nodeNameResolver->getName($argumentValue);
        }
        if ($name === null) {
            return $fallbackName;
        }
        return $name . $suffix;
    }
    private function unwrapNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Arg) {
            return $node->value;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast) {
            return $node->expr;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Ternary) {
            return $node->if;
        }
        return $node;
    }
    private function resolveParamNameFromArrayDimFetch(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : ?string
    {
        while ($arrayDimFetch instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            if ($arrayDimFetch->dim instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar) {
                $valueName = $this->nodeNameResolver->getName($arrayDimFetch->var);
                $dimName = $this->valueResolver->getValue($arrayDimFetch->dim);
                $dimName = \_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::underscoreToPascalCase($dimName);
                return $valueName . $dimName;
            }
            $arrayDimFetch = $arrayDimFetch->var;
        }
        return $this->resolveBareFromNode($arrayDimFetch);
    }
    private function resolveFromPropertyFetch(\_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : string
    {
        $varName = $this->nodeNameResolver->getName($propertyFetch->var);
        if (!\is_string($varName)) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException();
        }
        $propertyName = $this->nodeNameResolver->getName($propertyFetch->name);
        if (!\is_string($propertyName)) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException();
        }
        if ($varName === 'this') {
            return $propertyName;
        }
        return $varName . \ucfirst($propertyName);
    }
    /**
     * @param MethodCall|NullsafeMethodCall|StaticCall $expr
     */
    private function resolveFromMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : ?string
    {
        if ($expr->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return $this->resolveFromMethodCall($expr->name);
        }
        $methodName = $this->nodeNameResolver->getName($expr->name);
        if (!\is_string($methodName)) {
            return null;
        }
        return $methodName;
    }
    private function resolveFromNew(\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ $new) : string
    {
        if ($new->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            $className = $this->nodeNameResolver->getName($new->class);
            return $this->classNaming->getShortName($className);
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedYetException();
    }
}
