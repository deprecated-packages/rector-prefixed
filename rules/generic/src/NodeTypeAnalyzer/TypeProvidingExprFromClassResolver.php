<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\NodeTypeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpPropertyReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper, \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming $propertyNaming)
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
    public function resolveTypeProvidingExprFromClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike, string $type) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        $className = $class->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
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
        $scope = $class->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \_PhpScopere8e811afab72\PHPStan\Analyser\Scope) {
            return null;
        }
        $propertyFetch = $this->resolvePropertyFetchProvidingType($classReflection, $scope, $type);
        if ($propertyFetch !== null) {
            return $propertyFetch;
        }
        // C. param in constructor?
        return $this->resolveConstructorParamProvidingType($functionLike, $type);
    }
    private function resolveMethodCallProvidingType(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, string $type) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        foreach ($classReflection->getNativeMethods() as $methodReflection) {
            $functionVariant = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants());
            $returnType = $functionVariant->getReturnType();
            if (!$this->isMatchingType($returnType, $type)) {
                continue;
            }
            $thisVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this');
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($thisVariable, $methodReflection->getName());
        }
        return null;
    }
    private function resolvePropertyFetchProvidingType(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, string $type) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch
    {
        $nativeReflection = $classReflection->getNativeReflection();
        foreach ($nativeReflection->getProperties() as $reflectionProperty) {
            /** @var PhpPropertyReflection $phpPropertyReflection */
            $phpPropertyReflection = $classReflection->getProperty($reflectionProperty->getName(), $scope);
            $readableType = $phpPropertyReflection->getReadableType();
            if (!$this->isMatchingType($readableType, $type)) {
                continue;
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), $reflectionProperty->getName());
        }
        return null;
    }
    private function resolveConstructorParamProvidingType(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike, string $type) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable
    {
        if (!$functionLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        if (!$this->nodeNameResolver->isName($functionLike, \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return null;
        }
        $variableName = $this->propertyNaming->fqnToVariableName($type);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($variableName);
    }
    private function isMatchingType(\_PhpScopere8e811afab72\PHPStan\Type\Type $readableType, string $type) : bool
    {
        if ($readableType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return \false;
        }
        $readableType = $this->typeUnwrapper->unwrapNullableType($readableType);
        if (!$readableType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        return $readableType->getClassName() === $type;
    }
}
