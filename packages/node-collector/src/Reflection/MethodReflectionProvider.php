<?php

declare (strict_types=1);
namespace Rector\NodeCollector\Reflection;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
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
use ReflectionMethod;
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
    public function __construct(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->reflectionProvider = $reflectionProvider;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return Type[]
     */
    public function provideParameterTypesFromMethodReflection(\PHPStan\Reflection\MethodReflection $methodReflection) : array
    {
        if ($methodReflection instanceof \PHPStan\Reflection\Native\NativeMethodReflection) {
            // method "getParameters()" does not exist there
            return [];
        }
        $parameterTypes = [];
        $parameterReflections = $this->getParameterReflectionsFromMethodReflection($methodReflection);
        foreach ($parameterReflections as $phpParameterReflection) {
            $parameterTypes[] = $phpParameterReflection->getType();
        }
        return $parameterTypes;
    }
    public function provideByMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall) : ?\ReflectionMethod
    {
        $className = $methodCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if (!\is_string($className)) {
            return null;
        }
        $methodName = $this->nodeNameResolver->getName($methodCall->name);
        if ($methodName === null) {
            return null;
        }
        if (!\method_exists($className, $methodName)) {
            return null;
        }
        return new \ReflectionMethod($className, $methodName);
    }
    public function provideByClassAndMethodName(string $class, string $method, \PHPStan\Analyser\Scope $scope) : ?\PHPStan\Reflection\MethodReflection
    {
        $classReflection = $this->reflectionProvider->getClass($class);
        if (!$classReflection->hasMethod($method)) {
            return null;
        }
        return $classReflection->getMethod($method, $scope);
    }
    /**
     * @return Type[]
     */
    public function provideParameterTypesByStaticCall(\PhpParser\Node\Expr\StaticCall $staticCall) : array
    {
        $methodReflection = $this->provideByStaticCall($staticCall);
        if (!$methodReflection instanceof \PHPStan\Reflection\MethodReflection) {
            return [];
        }
        return $this->provideParameterTypesFromMethodReflection($methodReflection);
    }
    public function provideByStaticCall(\PhpParser\Node\Expr\StaticCall $staticCall) : ?\PHPStan\Reflection\MethodReflection
    {
        $objectType = $this->nodeTypeResolver->resolve($staticCall->class);
        $classes = \PHPStan\Type\TypeUtils::getDirectClassNames($objectType);
        $methodName = $this->nodeNameResolver->getName($staticCall->name);
        if ($methodName === null) {
            return null;
        }
        return $this->provideByClassNamesAndMethodName($classes, $methodName, $staticCall);
    }
    /**
     * @return Type[]
     */
    public function provideParameterTypesByClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $methodReflection = $this->provideByClassMethod($classMethod);
        if (!$methodReflection instanceof \PHPStan\Reflection\MethodReflection) {
            return [];
        }
        return $this->provideParameterTypesFromMethodReflection($methodReflection);
    }
    public function provideByClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PHPStan\Reflection\MethodReflection
    {
        $class = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if (!\is_string($class)) {
            return null;
        }
        $method = $this->nodeNameResolver->getName($classMethod->name);
        if (!\is_string($method)) {
            return null;
        }
        $scope = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            return null;
        }
        return $this->provideByClassAndMethodName($class, $method, $scope);
    }
    /**
     * @return ParameterReflection[]
     */
    public function getParameterReflectionsFromMethodReflection(\PHPStan\Reflection\MethodReflection $methodReflection) : array
    {
        $methodReflectionVariant = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants());
        return $methodReflectionVariant->getParameters();
    }
    /**
     * @return string[]
     */
    public function provideParameterNamesByNew(\PhpParser\Node\Expr\New_ $new) : array
    {
        $objectType = $this->nodeTypeResolver->resolve($new->class);
        $classes = \PHPStan\Type\TypeUtils::getDirectClassNames($objectType);
        $parameterNames = [];
        foreach ($classes as $class) {
            if (!\method_exists($class, \Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
                continue;
            }
            $methodReflection = new \ReflectionMethod($class, \Rector\Core\ValueObject\MethodName::CONSTRUCT);
            foreach ($methodReflection->getParameters() as $reflectionParameter) {
                $parameterNames[] = $reflectionParameter->name;
            }
        }
        return $parameterNames;
    }
    /**
     * @param string[] $classes
     */
    private function provideByClassNamesAndMethodName(array $classes, string $methodName, \PhpParser\Node\Expr\StaticCall $staticCall) : ?\PHPStan\Reflection\MethodReflection
    {
        /** @var Scope|null $scope */
        $scope = $staticCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        foreach ($classes as $class) {
            $methodReflection = $this->provideByClassAndMethodName($class, $methodName, $scope);
            if ($methodReflection instanceof \PHPStan\Reflection\MethodReflection) {
                return $methodReflection;
            }
        }
        return null;
    }
}
