<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Generic\NodeTypeAnalyzer;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\PhpPropertyReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a2ac50786fa\Rector\Naming\Naming\PropertyNaming;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
final class TypeProvidingExprFromClassResolver
{
    /**
     * @var TypeUnwrapper
     */
    private $typeUnwrapper;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a2ac50786fa\Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->typeUnwrapper = $typeUnwrapper;
        $this->reflectionProvider = $reflectionProvider;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->propertyNaming = $propertyNaming;
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     * @return MethodCall|PropertyFetch|Variable|null
     */
    public function resolveTypeProvidingExprFromClass(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike $functionLike, string $type) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        $className = $class->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return null;
        }
        // A. match a method
        $classReflection = $this->reflectionProvider->getClass($className);
        $methodCallProvidingType = $this->resolveMethodCallProvidingType($classReflection, $type);
        if ($methodCallProvidingType !== null) {
            return $methodCallProvidingType;
        }
        // B. match existing property
        $scope = $class->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope) {
            return null;
        }
        $propertyFetch = $this->resolvePropertyFetchProvidingType($classReflection, $scope, $type);
        if ($propertyFetch !== null) {
            return $propertyFetch;
        }
        // C. param in constructor?
        return $this->resolveConstructorParamProvidingType($functionLike, $type);
    }
    private function resolveMethodCallProvidingType(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection, string $type) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
    {
        foreach ($classReflection->getNativeMethods() as $methodReflection) {
            $functionVariant = \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants());
            $returnType = $functionVariant->getReturnType();
            if (!$this->isMatchingType($returnType, $type)) {
                continue;
            }
            $thisVariable = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable('this');
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($thisVariable, $methodReflection->getName());
        }
        return null;
    }
    private function resolvePropertyFetchProvidingType(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, string $type) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch
    {
        $nativeReflection = $classReflection->getNativeReflection();
        foreach ($nativeReflection->getProperties() as $reflectionProperty) {
            /** @var PhpPropertyReflection $phpPropertyReflection */
            $phpPropertyReflection = $classReflection->getProperty($reflectionProperty->getName(), $scope);
            $readableType = $phpPropertyReflection->getReadableType();
            if (!$this->isMatchingType($readableType, $type)) {
                continue;
            }
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable('this'), $reflectionProperty->getName());
        }
        return null;
    }
    private function resolveConstructorParamProvidingType(\_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike $functionLike, string $type) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable
    {
        if (!$functionLike instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        if (!$this->nodeNameResolver->isName($functionLike, \_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return null;
        }
        $variableName = $this->propertyNaming->fqnToVariableName($type);
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable($variableName);
    }
    private function isMatchingType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $readableType, string $type) : bool
    {
        if ($readableType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            return \false;
        }
        $readableType = $this->typeUnwrapper->unwrapNullableType($readableType);
        if (!$readableType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        return $readableType->getClassName() === $type;
    }
}
