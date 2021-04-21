<?php

declare(strict_types=1);

namespace Rector\NodeCollector\Reflection;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\Native\NativeMethodReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\Type;
use PHPStan\Type\TypeUtils;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\ValueObject\MethodName;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;

final class MethodReflectionProvider
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;

    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;

    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    public function __construct(
        NodeTypeResolver $nodeTypeResolver,
        NodeNameResolver $nodeNameResolver,
        ReflectionProvider $reflectionProvider
    ) {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->reflectionProvider = $reflectionProvider;
        $this->nodeNameResolver = $nodeNameResolver;
    }

    /**
     * @return Type[]
     */
    public function provideParameterTypesFromMethodReflection(MethodReflection $methodReflection): array
    {
        if ($methodReflection instanceof NativeMethodReflection) {
            // method "getParameters()" does not exist there
            return [];
        }

        $parameterTypes = [];

        $parameterReflections = $this->getParameterReflectionsFromMethodReflection($methodReflection);
        foreach ($parameterReflections as $parameterReflection) {
            $parameterTypes[] = $parameterReflection->getType();
        }

        return $parameterTypes;
    }

    /**
     * @return \PHPStan\Reflection\MethodReflection|null
     */
    public function provideByMethodCall(MethodCall $methodCall)
    {
        $className = $methodCall->getAttribute(AttributeKey::CLASS_NAME);
        if (! is_string($className)) {
            return null;
        }

        $methodName = $this->nodeNameResolver->getName($methodCall->name);
        if ($methodName === null) {
            return null;
        }

        if (! $this->reflectionProvider->hasClass($className)) {
            return null;
        }

        $classReflection = $this->reflectionProvider->getClass($className);
        if (! $classReflection->hasMethod($methodName)) {
            return null;
        }

        return $classReflection->getNativeMethod($methodName);
    }

    /**
     * @return Type[]
     */
    public function provideParameterTypesByStaticCall(StaticCall $staticCall): array
    {
        $methodReflection = $this->provideByStaticCall($staticCall);
        if (! $methodReflection instanceof MethodReflection) {
            return [];
        }

        return $this->provideParameterTypesFromMethodReflection($methodReflection);
    }

    /**
     * @return \PHPStan\Reflection\MethodReflection|null
     */
    public function provideByStaticCall(StaticCall $staticCall)
    {
        $objectType = $this->nodeTypeResolver->resolve($staticCall->class);
        $classes = TypeUtils::getDirectClassNames($objectType);

        $methodName = $this->nodeNameResolver->getName($staticCall->name);
        if ($methodName === null) {
            return null;
        }

        return $this->provideByClassNamesAndMethodName($classes, $methodName, $staticCall);
    }

    /**
     * @return Type[]
     */
    public function provideParameterTypesByClassMethod(ClassMethod $classMethod): array
    {
        $methodReflection = $this->provideByClassMethod($classMethod);
        if (! $methodReflection instanceof MethodReflection) {
            return [];
        }

        return $this->provideParameterTypesFromMethodReflection($methodReflection);
    }

    /**
     * @return \PHPStan\Reflection\MethodReflection|null
     */
    public function provideByClassMethod(ClassMethod $classMethod)
    {
        $class = $classMethod->getAttribute(AttributeKey::CLASS_NAME);
        if (! is_string($class)) {
            return null;
        }

        $method = $this->nodeNameResolver->getName($classMethod->name);
        if (! is_string($method)) {
            return null;
        }

        $scope = $classMethod->getAttribute(AttributeKey::SCOPE);
        if (! $scope instanceof Scope) {
            return null;
        }

        $classReflection = $scope->getClassReflection();
        if (! $classReflection instanceof ClassReflection) {
            return null;
        }

        return $classReflection->getMethod($method, $scope);
    }

    /**
     * @return ParameterReflection[]
     */
    public function getParameterReflectionsFromMethodReflection(MethodReflection $methodReflection): array
    {
        $parametersAcceptor = ParametersAcceptorSelector::selectSingle($methodReflection->getVariants());
        return $parametersAcceptor->getParameters();
    }

    /**
     * @return string[]
     */
    public function provideParameterNamesByNew(New_ $new): array
    {
        $objectType = $this->nodeTypeResolver->resolve($new->class);

        $classes = TypeUtils::getDirectClassNames($objectType);

        $parameterNames = [];

        foreach ($classes as $class) {
            if (! $this->reflectionProvider->hasClass($class)) {
                continue;
            }

            $classReflection = $this->reflectionProvider->getClass($class);

            if (! $classReflection->hasMethod(MethodName::CONSTRUCT)) {
                continue;
            }

            $nativeClassReflection = $classReflection->getNativeReflection();
            $methodReflection = $nativeClassReflection->getMethod(MethodName::CONSTRUCT);

            foreach ($methodReflection->getParameters() as $reflectionParameter) {
                $parameterNames[] = $reflectionParameter->getName();
            }
        }

        return $parameterNames;
    }

    /**
     * @param string[] $classes
     * @return \PHPStan\Reflection\MethodReflection|null
     */
    private function provideByClassNamesAndMethodName(
        array $classes,
        string $methodName,
        StaticCall $staticCall
    ) {
        /** @var Scope|null $scope */
        $scope = $staticCall->getAttribute(AttributeKey::SCOPE);
        if (! $scope instanceof Scope) {
            throw new ShouldNotHappenException();
        }

        foreach ($classes as $class) {
            $classReflection = $this->reflectionProvider->getClass($class);
            if (! $classReflection->hasMethod($methodName)) {
                continue;
            }

            return $classReflection->getMethod($methodName, $scope);
        }

        return null;
    }
}
