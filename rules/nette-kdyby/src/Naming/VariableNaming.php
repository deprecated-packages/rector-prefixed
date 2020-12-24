<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteKdyby\Naming;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafeMethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Ternary;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Type\ThisType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedException;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedYetException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->valueResolver = $valueResolver;
        $this->classNaming = $classNaming;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function resolveFromNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        $nodeType = $this->nodeTypeResolver->getStaticType($node);
        return $this->resolveFromNodeAndType($node, $nodeType);
    }
    public function resolveFromNodeAndType(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : ?string
    {
        $variableName = $this->resolveBareFromNode($node);
        if ($variableName === null) {
            return null;
        }
        // adjust static to specific class
        if ($variableName === 'this' && $type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ThisType) {
            $shortClassName = $this->classNaming->getShortName($type->getClassName());
            $variableName = \lcfirst($shortClassName);
        }
        return \_PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings::underscoreToCamelCase($variableName);
    }
    public function resolveFromNodeWithScopeCountAndFallbackName(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, string $fallbackName) : string
    {
        $name = $this->resolveFromNode($expr);
        if ($name === null) {
            $name = $fallbackName;
        }
        return \lcfirst($this->createCountedValueName($name, $scope));
    }
    public function createCountedValueName(string $valueName, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : string
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
    public function resolveFromFuncCallFirstArgumentWithSuffix(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall, string $suffix, string $fallbackName, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : string
    {
        $bareName = $this->resolveBareFuncCallArgumentName($funcCall, $fallbackName, $suffix);
        return $this->createCountedValueName($bareName, $scope);
    }
    private function resolveBareFromNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        $node = $this->unwrapNode($node);
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch) {
            return $this->resolveParamNameFromArrayDimFetch($node);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            return $this->resolveFromPropertyFetch($node);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafeMethodCall || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
            return $this->resolveFromMethodCall($node);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_) {
            return $this->resolveFromNew($node);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            return $this->resolveFromNode($node->name);
        }
        if ($node === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedException();
        }
        $paramName = $this->nodeNameResolver->getName($node);
        if ($paramName !== null) {
            return $paramName;
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
            return $node->value;
        }
        return null;
    }
    private function resolveBareFuncCallArgumentName(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall, string $fallbackName, string $suffix) : string
    {
        $argumentValue = $funcCall->args[0]->value;
        if ($argumentValue instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall || $argumentValue instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
            $name = $this->nodeNameResolver->getName($argumentValue->name);
        } else {
            $name = $this->nodeNameResolver->getName($argumentValue);
        }
        if ($name === null) {
            return $fallbackName;
        }
        return $name . $suffix;
    }
    private function unwrapNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Arg) {
            return $node->value;
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast) {
            return $node->expr;
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Ternary) {
            return $node->if;
        }
        return $node;
    }
    private function resolveParamNameFromArrayDimFetch(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : ?string
    {
        while ($arrayDimFetch instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch) {
            if ($arrayDimFetch->dim instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar) {
                $valueName = $this->nodeNameResolver->getName($arrayDimFetch->var);
                $dimName = $this->valueResolver->getValue($arrayDimFetch->dim);
                $dimName = \_PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings::underscoreToPascalCase($dimName);
                return $valueName . $dimName;
            }
            $arrayDimFetch = $arrayDimFetch->var;
        }
        return $this->resolveBareFromNode($arrayDimFetch);
    }
    private function resolveFromPropertyFetch(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : string
    {
        $varName = $this->nodeNameResolver->getName($propertyFetch->var);
        if (!\is_string($varName)) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedException();
        }
        $propertyName = $this->nodeNameResolver->getName($propertyFetch->name);
        if (!\is_string($propertyName)) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedException();
        }
        if ($varName === 'this') {
            return $propertyName;
        }
        return $varName . \ucfirst($propertyName);
    }
    /**
     * @param MethodCall|NullsafeMethodCall|StaticCall $expr
     */
    private function resolveFromMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : ?string
    {
        if ($expr->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return $this->resolveFromMethodCall($expr->name);
        }
        $methodName = $this->nodeNameResolver->getName($expr->name);
        if (!\is_string($methodName)) {
            return null;
        }
        return $methodName;
    }
    private function resolveFromNew(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_ $new) : string
    {
        if ($new->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            $className = $this->nodeNameResolver->getName($new->class);
            return $this->classNaming->getShortName($className);
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedYetException();
    }
}
