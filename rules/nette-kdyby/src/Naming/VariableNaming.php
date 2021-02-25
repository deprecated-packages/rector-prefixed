<?php

declare (strict_types=1);
namespace Rector\NetteKdyby\Naming;

use RectorPrefix20210225\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Cast;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\NullsafeMethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Ternary;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\Scope;
use PHPStan\Type\ThisType;
use PHPStan\Type\Type;
use Rector\Core\Exception\NotImplementedYetException;
use Rector\Core\PhpParser\Node\Value\ValueResolver;
use Rector\Core\Util\StaticInstanceOf;
use Rector\Core\Util\StaticRectorStrings;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\NodeTypeResolver;
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
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->valueResolver = $valueResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function resolveFromNode(\PhpParser\Node $node) : ?string
    {
        $nodeType = $this->nodeTypeResolver->getStaticType($node);
        return $this->resolveFromNodeAndType($node, $nodeType);
    }
    public function resolveFromNodeAndType(\PhpParser\Node $node, \PHPStan\Type\Type $type) : ?string
    {
        $variableName = $this->resolveBareFromNode($node);
        if ($variableName === null) {
            return null;
        }
        // adjust static to specific class
        if ($variableName === 'this' && $type instanceof \PHPStan\Type\ThisType) {
            $shortClassName = $this->nodeNameResolver->getShortName($type->getClassName());
            $variableName = \lcfirst($shortClassName);
        }
        return \Rector\Core\Util\StaticRectorStrings::underscoreToCamelCase($variableName);
    }
    public function resolveFromNodeWithScopeCountAndFallbackName(\PhpParser\Node\Expr $expr, \PHPStan\Analyser\Scope $scope, string $fallbackName) : string
    {
        $name = $this->resolveFromNode($expr);
        if ($name === null) {
            $name = $fallbackName;
        }
        if (\RectorPrefix20210225\Nette\Utils\Strings::contains($name, '\\')) {
            $name = (string) \RectorPrefix20210225\Nette\Utils\Strings::after($name, '\\', -1);
        }
        $countedValueName = $this->createCountedValueName($name, $scope);
        return \lcfirst($countedValueName);
    }
    public function createCountedValueName(string $valueName, ?\PHPStan\Analyser\Scope $scope) : string
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
    public function resolveFromFuncCallFirstArgumentWithSuffix(\PhpParser\Node\Expr\FuncCall $funcCall, string $suffix, string $fallbackName, ?\PHPStan\Analyser\Scope $scope) : string
    {
        $bareName = $this->resolveBareFuncCallArgumentName($funcCall, $fallbackName, $suffix);
        return $this->createCountedValueName($bareName, $scope);
    }
    private function resolveBareFromNode(\PhpParser\Node $node) : ?string
    {
        $node = $this->unwrapNode($node);
        if ($node instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            return $this->resolveParamNameFromArrayDimFetch($node);
        }
        if ($node instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return $this->resolveFromPropertyFetch($node);
        }
        if ($this->isCall($node)) {
            return $this->resolveFromMethodCall($node);
        }
        if ($node instanceof \PhpParser\Node\Expr\New_) {
            return $this->resolveFromNew($node);
        }
        if ($node instanceof \PhpParser\Node\Expr\FuncCall) {
            return $this->resolveFromNode($node->name);
        }
        if (!$node instanceof \PhpParser\Node) {
            throw new \Rector\Core\Exception\NotImplementedYetException();
        }
        $paramName = $this->nodeNameResolver->getName($node);
        if ($paramName !== null) {
            return $paramName;
        }
        if ($node instanceof \PhpParser\Node\Scalar\String_) {
            return $node->value;
        }
        return null;
    }
    private function resolveBareFuncCallArgumentName(\PhpParser\Node\Expr\FuncCall $funcCall, string $fallbackName, string $suffix) : string
    {
        $argumentValue = $funcCall->args[0]->value;
        if ($argumentValue instanceof \PhpParser\Node\Expr\MethodCall || $argumentValue instanceof \PhpParser\Node\Expr\StaticCall) {
            $name = $this->nodeNameResolver->getName($argumentValue->name);
        } else {
            $name = $this->nodeNameResolver->getName($argumentValue);
        }
        if ($name === null) {
            return $fallbackName;
        }
        return $name . $suffix;
    }
    private function unwrapNode(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Arg) {
            return $node->value;
        }
        if ($node instanceof \PhpParser\Node\Expr\Cast) {
            return $node->expr;
        }
        if ($node instanceof \PhpParser\Node\Expr\Ternary) {
            return $node->if;
        }
        return $node;
    }
    private function resolveParamNameFromArrayDimFetch(\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : ?string
    {
        while ($arrayDimFetch instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            if ($arrayDimFetch->dim instanceof \PhpParser\Node\Scalar) {
                $valueName = $this->nodeNameResolver->getName($arrayDimFetch->var);
                $dimName = $this->valueResolver->getValue($arrayDimFetch->dim);
                $dimName = \Rector\Core\Util\StaticRectorStrings::underscoreToPascalCase($dimName);
                return $valueName . $dimName;
            }
            $arrayDimFetch = $arrayDimFetch->var;
        }
        return $this->resolveBareFromNode($arrayDimFetch);
    }
    private function resolveFromPropertyFetch(\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : string
    {
        $varName = $this->nodeNameResolver->getName($propertyFetch->var);
        if (!\is_string($varName)) {
            throw new \Rector\Core\Exception\NotImplementedYetException();
        }
        $propertyName = $this->nodeNameResolver->getName($propertyFetch->name);
        if (!\is_string($propertyName)) {
            throw new \Rector\Core\Exception\NotImplementedYetException();
        }
        if ($varName === 'this') {
            return $propertyName;
        }
        return $varName . \ucfirst($propertyName);
    }
    private function isCall(?\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \PhpParser\Node) {
            return \false;
        }
        return \Rector\Core\Util\StaticInstanceOf::isOneOf($node, [\PhpParser\Node\Expr\MethodCall::class, \PhpParser\Node\Expr\NullsafeMethodCall::class, \PhpParser\Node\Expr\StaticCall::class]);
    }
    private function resolveFromMethodCall(?\PhpParser\Node $node) : ?string
    {
        if (!$node instanceof \PhpParser\Node) {
            return null;
        }
        if (!\property_exists($node, 'name')) {
            return null;
        }
        if ($node->name instanceof \PhpParser\Node\Expr\MethodCall) {
            return $this->resolveFromMethodCall($node->name);
        }
        $methodName = $this->nodeNameResolver->getName($node->name);
        if (!\is_string($methodName)) {
            return null;
        }
        return $methodName;
    }
    private function resolveFromNew(\PhpParser\Node\Expr\New_ $new) : string
    {
        if ($new->class instanceof \PhpParser\Node\Name) {
            $className = $this->nodeNameResolver->getName($new->class);
            return $this->nodeNameResolver->getShortName($className);
        }
        throw new \Rector\Core\Exception\NotImplementedYetException();
    }
}
