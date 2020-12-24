<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Interface_;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
use _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
final class MagicNetteFactoryInterfaceFormControlTypeResolver implements \_PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface, \_PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return [];
        }
        // skip constructor, handled elsewhere
        if ($this->nodeNameResolver->isName($node, \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return [];
        }
        $classMethod = $this->nodeRepository->findClassMethodByMethodCall($node);
        if ($classMethod === null) {
            return [];
        }
        $classLike = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        // magic interface handled esle where
        if (!$classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Interface_) {
            return [];
        }
        $returnedType = $this->nodeTypeResolver->getStaticType($node);
        if (!$returnedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName) {
            return [];
        }
        $constructorClassMethod = $this->nodeRepository->findClassMethod($returnedType->getClassName(), \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructorClassMethod === null) {
            return [];
        }
        return $this->methodNamesByInputNamesResolver->resolveExpr($constructorClassMethod);
    }
    public function setResolver(\_PhpScoper0a6b37af0871\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver) : void
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
}
