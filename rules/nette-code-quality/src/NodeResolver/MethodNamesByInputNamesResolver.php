<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\NodeResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
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
            if ($formControlTypeResolver instanceof \_PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface) {
                $formControlTypeResolver->setResolver($this);
            }
            $this->formControlTypeResolvers[] = $formControlTypeResolver;
        }
    }
    /**
     * @return array<string, string>
     */
    public function resolveExpr(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array
    {
        $methodNamesByInputNames = [];
        foreach ($this->formControlTypeResolvers as $formControlTypeResolver) {
            $currentMethodNamesByInputNames = $formControlTypeResolver->resolve($node);
            $methodNamesByInputNames = \array_merge($methodNamesByInputNames, $currentMethodNamesByInputNames);
        }
        return $methodNamesByInputNames;
    }
}
