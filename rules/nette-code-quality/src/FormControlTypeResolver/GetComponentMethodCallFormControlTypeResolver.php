<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
final class GetComponentMethodCallFormControlTypeResolver implements \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface, \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->valueResolver = $valueResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return [];
        }
        if (!$this->nodeNameResolver->isName($node->name, 'getComponent')) {
            return [];
        }
        $createComponentClassMethodName = $this->createCreateComponentMethodName($node);
        $staticType = $this->nodeTypeResolver->getStaticType($node);
        if (!$staticType instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType) {
            return [];
        }
        // combine constructor + method body name
        $constructorClassMethodData = [];
        $constructorClassMethod = $this->nodeRepository->findClassMethod($staticType->getClassName(), \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructorClassMethod !== null) {
            $constructorClassMethodData = $this->methodNamesByInputNamesResolver->resolveExpr($constructorClassMethod);
        }
        $callerType = $this->nodeTypeResolver->getStaticType($node->var);
        $createComponentClassMethodData = [];
        if ($callerType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            $createComponentClassMethod = $this->nodeRepository->findClassMethod($callerType->getClassName(), $createComponentClassMethodName);
            if ($createComponentClassMethod !== null) {
                $createComponentClassMethodData = $this->methodNamesByInputNamesResolver->resolveExpr($createComponentClassMethod);
            }
        }
        return \array_merge($constructorClassMethodData, $createComponentClassMethodData);
    }
    public function setResolver(\_PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver) : void
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
    private function createCreateComponentMethodName(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        $firstArgumentValue = $methodCall->args[0]->value;
        return 'createComponent' . \ucfirst($this->valueResolver->getValue($firstArgumentValue));
    }
}
