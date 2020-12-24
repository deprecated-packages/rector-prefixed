<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\SymfonyPHPUnit\Node;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isOnContainerGetMethodCall(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->isSelfContainerGetMethodCall($node);
    }
    /**
     * Is inside setUp() class method
     */
    public function isSetUpOrEmptyMethod(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        $methodName = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        return $methodName === \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::SET_UP || $methodName === null;
    }
    /**
     * Matches:
     * $this->getService()
     */
    private function isSelfContainerGetMethodCall(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node->name, 'get')) {
            return \false;
        }
        return $this->nodeTypeResolver->isObjectType($node->var, '_PhpScopere8e811afab72\\Symfony\\Component\\DependencyInjection\\ContainerInterface');
    }
}
