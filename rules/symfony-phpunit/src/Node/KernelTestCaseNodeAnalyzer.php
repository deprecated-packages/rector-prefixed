<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\SymfonyPHPUnit\Node;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isOnContainerGetMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        return $this->isSelfContainerGetMethodCall($node);
    }
    /**
     * Is inside setUp() class method
     */
    public function isSetUpOrEmptyMethod(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        $methodName = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        return $methodName === \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::SET_UP || $methodName === null;
    }
    /**
     * Matches:
     * $this->getService()
     */
    private function isSelfContainerGetMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node->name, 'get')) {
            return \false;
        }
        return $this->nodeTypeResolver->isObjectType($node->var, '_PhpScoperb75b35f52b74\\Symfony\\Component\\DependencyInjection\\ContainerInterface');
    }
}
