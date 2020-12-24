<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\SymfonyPHPUnit\Node;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
final class KernelTestCaseNodeAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isOnContainerGetMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        return $this->isSelfContainerGetMethodCall($node);
    }
    /**
     * Is inside setUp() class method
     */
    public function isSetUpOrEmptyMethod(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        $methodName = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        return $methodName === \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::SET_UP || $methodName === null;
    }
    /**
     * Matches:
     * $this->getService()
     */
    private function isSelfContainerGetMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node->name, 'get')) {
            return \false;
        }
        return $this->nodeTypeResolver->isObjectType($node->var, '_PhpScoper0a6b37af0871\\Symfony\\Component\\DependencyInjection\\ContainerInterface');
    }
}
