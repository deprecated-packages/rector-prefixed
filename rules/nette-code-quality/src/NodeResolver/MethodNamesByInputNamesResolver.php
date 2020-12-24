<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
final class MethodNamesByInputNamesResolver
{
    /**
     * @var FormControlTypeResolverInterface[]
     */
    private $formControlTypeResolvers = [];
    /**
     * @param FormControlTypeResolverInterface[] $formControlTypeResolvers
     */
    public function __construct(array $formControlTypeResolvers)
    {
        foreach ($formControlTypeResolvers as $formControlTypeResolver) {
            if ($formControlTypeResolver instanceof \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface) {
                $formControlTypeResolver->setResolver($this);
            }
            $this->formControlTypeResolvers[] = $formControlTypeResolver;
        }
    }
    /**
     * @return array<string, string>
     */
    public function resolveExpr(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        $methodNamesByInputNames = [];
        foreach ($this->formControlTypeResolvers as $formControlTypeResolver) {
            $currentMethodNamesByInputNames = $formControlTypeResolver->resolve($node);
            $methodNamesByInputNames = \array_merge($methodNamesByInputNames, $currentMethodNamesByInputNames);
        }
        return $methodNamesByInputNames;
    }
}
