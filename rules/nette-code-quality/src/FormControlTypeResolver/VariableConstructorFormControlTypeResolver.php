<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class VariableConstructorFormControlTypeResolver implements \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface, \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface
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
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return [];
        }
        // handled else-where
        if ($this->nodeNameResolver->isName($node, 'this')) {
            return [];
        }
        $formType = $this->nodeTypeResolver->getStaticType($node);
        if (!$formType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return [];
        }
        if (!\is_a($formType->getClassName(), '_PhpScopere8e811afab72\\Nette\\Application\\UI\\Form', \true)) {
            return [];
        }
        $constructorClassMethod = $this->nodeRepository->findClassMethod($formType->getClassName(), \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructorClassMethod === null) {
            return [];
        }
        return $this->methodNamesByInputNamesResolver->resolveExpr($constructorClassMethod);
    }
    public function setResolver(\_PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver) : void
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
}
