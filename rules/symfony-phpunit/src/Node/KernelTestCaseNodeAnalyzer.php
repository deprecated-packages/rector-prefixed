<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\SymfonyPHPUnit\Node;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isOnContainerGetMethodCall(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        return $this->isSelfContainerGetMethodCall($node);
    }
    /**
     * Is inside setUp() class method
     */
    public function isSetUpOrEmptyMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        $methodName = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        return $methodName === \_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::SET_UP || $methodName === null;
    }
    /**
     * Matches:
     * self::$container->get()
     */
    private function isSelfContainerGetMethodCall(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node->name, 'get')) {
            return \false;
        }
        return $this->nodeTypeResolver->isObjectType($node->var, '_PhpScoper0a2ac50786fa\\Symfony\\Component\\DependencyInjection\\ContainerInterface');
    }
}
