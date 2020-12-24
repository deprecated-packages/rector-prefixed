<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
use _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
final class MethodCallFormControlTypeResolver implements \_PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface, \_PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
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
        if ($this->nodeNameResolver->isName($node->name, 'getComponent')) {
            return [];
        }
        $classMethod = $this->nodeRepository->findClassMethodByMethodCall($node);
        if ($classMethod === null) {
            return [];
        }
        return $this->methodNamesByInputNamesResolver->resolveExpr($classMethod);
    }
    public function setResolver(\_PhpScoper0a6b37af0871\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver) : void
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
}
