<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeCollector\Reflection;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Native\NativeMethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParameterReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->reflectionProvider = $reflectionProvider;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return Type[]
     */
    public function provideParameterTypesFromMethodReflection(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection) : array
    {
        if ($methodReflection instanceof \_PhpScoper0a6b37af0871\PHPStan\Reflection\Native\NativeMethodReflection) {
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
    public function provideByClassAndMethodName(string $class, string $method, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : ?\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection
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
    public function provideParameterTypesByStaticCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $staticCall) : array
    {
        $methodReflection = $this->provideByStaticCall($staticCall);
        if ($methodReflection === null) {
            return [];
        }
        return $this->provideParameterTypesFromMethodReflection($methodReflection);
    }
    public function provideByNew(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_ $new) : ?\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection
    {
        $objectType = $this->nodeTypeResolver->resolve($new->class);
        $classes = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getDirectClassNames($objectType);
        return $this->provideByClassNamesAndMethodName($classes, \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT, $new);
    }
    public function provideByStaticCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $staticCall) : ?\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection
    {
        $objectType = $this->nodeTypeResolver->resolve($staticCall->class);
        $classes = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getDirectClassNames($objectType);
        $methodName = $this->nodeNameResolver->getName($staticCall->name);
        if ($methodName === null) {
            return null;
        }
        return $this->provideByClassNamesAndMethodName($classes, $methodName, $staticCall);
    }
    /**
     * @return Type[]
     */
    public function provideParameterTypesByClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $methodReflection = $this->provideByClassMethod($classMethod);
        if ($methodReflection === null) {
            return [];
        }
        return $this->provideParameterTypesFromMethodReflection($methodReflection);
    }
    public function provideByClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection
    {
        $class = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if (!\is_string($class)) {
            return null;
        }
        $method = $this->nodeNameResolver->getName($classMethod->name);
        if (!\is_string($method)) {
            return null;
        }
        $scope = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope) {
            return null;
        }
        return $this->provideByClassAndMethodName($class, $method, $scope);
    }
    /**
     * @return ParameterReflection[]
     */
    public function getParameterReflectionsFromMethodReflection(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection) : array
    {
        $methodReflectionVariant = \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants());
        return $methodReflectionVariant->getParameters();
    }
    /**
     * @return string[]
     */
    public function provideParameterNamesByNew(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_ $new) : array
    {
        $objectType = $this->nodeTypeResolver->resolve($new->class);
        $classes = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getDirectClassNames($objectType);
        $parameterNames = [];
        foreach ($classes as $class) {
            if (!\method_exists($class, \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
                continue;
            }
            $methodReflection = new \ReflectionMethod($class, \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT);
            foreach ($methodReflection->getParameters() as $reflectionParameter) {
                $parameterNames[] = $reflectionParameter->name;
            }
        }
        return $parameterNames;
    }
    /**
     * @param string[] $classes
     */
    private function provideByClassNamesAndMethodName(array $classes, string $methodName, \_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection
    {
        /** @var Scope|null $scope */
        $scope = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        foreach ($classes as $class) {
            $methodReflection = $this->provideByClassAndMethodName($class, $methodName, $scope);
            if ($methodReflection instanceof \_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection) {
                return $methodReflection;
            }
        }
        return null;
    }
}
