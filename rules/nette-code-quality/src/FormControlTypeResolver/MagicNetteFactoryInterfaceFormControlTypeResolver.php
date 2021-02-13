<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\FormControlTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Interface_;
use PHPStan\Type\TypeWithClassName;
use Rector\Core\ValueObject\MethodName;
use Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
use Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class MagicNetteFactoryInterfaceFormControlTypeResolver implements \Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface, \Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface
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
    public function __construct(\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\PhpParser\Node $node) : array
    {
        if (!$node instanceof \PhpParser\Node\Expr\MethodCall) {
            return [];
        }
        // skip constructor, handled elsewhere
        if ($this->nodeNameResolver->isName($node->name, \Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return [];
        }
        $classMethod = $this->nodeRepository->findClassMethodByMethodCall($node);
        if (!$classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return [];
        }
        $classLike = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        // magic interface handled esle where
        if (!$classLike instanceof \PhpParser\Node\Stmt\Interface_) {
            return [];
        }
        $returnedType = $this->nodeTypeResolver->getStaticType($node);
        if (!$returnedType instanceof \PHPStan\Type\TypeWithClassName) {
            return [];
        }
        $constructorClassMethod = $this->nodeRepository->findClassMethod($returnedType->getClassName(), \Rector\Core\ValueObject\MethodName::CONSTRUCT);
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
