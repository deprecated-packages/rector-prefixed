<?php

declare(strict_types=1);

namespace Rector\Nette\FormControlTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\TypeWithClassName;
use Rector\Core\PhpParser\Parser\FunctionLikeParser;
use Rector\Core\ValueObject\MethodName;
use Rector\Nette\Contract\FormControlTypeResolverInterface;
use Rector\Nette\Contract\MethodNamesByInputNamesResolverAwareInterface;
use Rector\Nette\NodeResolver\MethodNamesByInputNamesResolver;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\NodeTypeResolver;

final class MagicNetteFactoryInterfaceFormControlTypeResolver implements FormControlTypeResolverInterface, MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;

    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;

    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @var NodeRepository
     */
    private $nodeRepository;

    /**
     * @var FunctionLikeParser
     */
    private $functionLikeParser;

    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;

    public function __construct(
        NodeRepository $nodeRepository,
        NodeNameResolver $nodeNameResolver,
        NodeTypeResolver $nodeTypeResolver,
        FunctionLikeParser $functionLikeParser,
        ReflectionProvider $reflectionProvider
    ) {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeRepository = $nodeRepository;
        $this->functionLikeParser = $functionLikeParser;
        $this->reflectionProvider = $reflectionProvider;
    }

    /**
     * @return array<string, string>
     */
    public function resolve(Node $node): array
    {
        if (! $node instanceof MethodCall) {
            return [];
        }

        // skip constructor, handled elsewhere
        if ($this->nodeNameResolver->isName($node->name, MethodName::CONSTRUCT)) {
            return [];
        }

        $methodName = $this->nodeNameResolver->getName($node->name);
        if ($methodName === null) {
            return [];
        }

        $classMethod = $this->nodeRepository->findClassMethodByMethodCall($node);
        if (! $classMethod instanceof ClassMethod) {
            $classMethod = $this->resolveReflectionClassMethod($node, $methodName);
            if (! $classMethod instanceof ClassMethod) {
                return [];
            }
        }

        $classReflection = $this->resolveClassReflectionByMethodCall($node);
        if (! $classReflection instanceof ClassReflection) {
            return [];
        }

        $returnedType = $this->nodeTypeResolver->getStaticType($node);
        if (! $returnedType instanceof TypeWithClassName) {
            return [];
        }

        $constructorClassMethod = $this->nodeRepository->findClassMethod(
            $returnedType->getClassName(),
            MethodName::CONSTRUCT
        );

        if (! $constructorClassMethod instanceof ClassMethod) {
            $constructorClassMethod = $this->resolveReflectionClassMethodFromClassNameAndMethod(
                $returnedType->getClassName(),
                MethodName::CONSTRUCT
            );
            if (! $classMethod instanceof ClassMethod) {
                return [];
            }
        }

        if (! $constructorClassMethod instanceof ClassMethod) {
            return [];
        }

        return $this->methodNamesByInputNamesResolver->resolveExpr($constructorClassMethod);
    }

    /**
     * @return void
     */
    public function setResolver(MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver)
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }

    /**
     * @return \PhpParser\Node\Stmt\ClassMethod|null
     */
    private function resolveReflectionClassMethod(MethodCall $methodCall, string $methodName)
    {
        $classReflection = $this->resolveClassReflectionByMethodCall($methodCall);
        if (! $classReflection instanceof ClassReflection) {
            return null;
        }

        $methodReflection = $classReflection->getNativeMethod($methodName);

        return $this->functionLikeParser->parseMethodReflection($methodReflection);
    }

    /**
     * @return \PhpParser\Node\Stmt\ClassMethod|null
     */
    private function resolveReflectionClassMethodFromClassNameAndMethod(
        string $className,
        string $methodName
    ) {
        if (! $this->reflectionProvider->hasClass($className)) {
            return null;
        }

        $classReflection = $this->reflectionProvider->getClass($className);
        $methodReflection = $classReflection->getNativeMethod($methodName);
        return $this->functionLikeParser->parseMethodReflection($methodReflection);
    }

    /**
     * @return \PHPStan\Reflection\ClassReflection|null
     */
    private function resolveClassReflectionByMethodCall(MethodCall $methodCall)
    {
        $callerClassName = $this->nodeRepository->resolveCallerClassName($methodCall);
        if ($callerClassName === null) {
            return null;
        }

        if (! $this->reflectionProvider->hasClass($callerClassName)) {
            return null;
        }

        return $this->reflectionProvider->getClass($callerClassName);
    }
}
