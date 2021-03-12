<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\FormControlTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\TypeWithClassName;
use Rector\Core\ValueObject\MethodName;
use Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
use Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class VariableConstructorFormControlTypeResolver implements \Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface, \Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    public function __construct(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeRepository = $nodeRepository;
        $this->reflectionProvider = $reflectionProvider;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\PhpParser\Node $node) : array
    {
        if (!$node instanceof \PhpParser\Node\Expr\Variable) {
            return [];
        }
        // handled else-where
        if ($this->nodeNameResolver->isName($node, 'this')) {
            return [];
        }
        $formType = $this->nodeTypeResolver->getStaticType($node);
        if (!$formType instanceof \PHPStan\Type\TypeWithClassName) {
            return [];
        }
        $formClassReflection = $this->reflectionProvider->getClass($formType->getClassName());
        if (!$formClassReflection->isSubclassOf('Nette\\Application\\UI\\Form')) {
            return [];
        }
        $constructorClassMethod = $this->nodeRepository->findClassMethod($formType->getClassName(), \Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if (!$constructorClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return [];
        }
        return $this->methodNamesByInputNamesResolver->resolveExpr($constructorClassMethod);
    }
    public function setResolver(\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver) : void
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
}
