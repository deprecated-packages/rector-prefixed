<?php

declare (strict_types=1);
namespace Rector\Nette\NodeResolver;

use PhpParser\Node;
use Rector\Nette\Contract\MethodNamesByInputNamesResolverAwareInterface;
final class MethodNamesByInputNamesResolver
{
    /**
     * @var \Rector\Nette\Contract\FormControlTypeResolverInterface[]
     */
    private $formControlTypeResolvers = [];
    /**
     * @param \Rector\Nette\Contract\FormControlTypeResolverInterface[] $formControlTypeResolvers
     */
    public function __construct(array $formControlTypeResolvers)
    {
        foreach ($formControlTypeResolvers as $formControlTypeResolver) {
            if ($formControlTypeResolver instanceof \Rector\Nette\Contract\MethodNamesByInputNamesResolverAwareInterface) {
                $formControlTypeResolver->setResolver($this);
            }
            $this->formControlTypeResolvers[] = $formControlTypeResolver;
        }
    }
    /**
     * @return array<string, class-string>
     */
    public function resolveExpr(\PhpParser\Node $node) : array
    {
        $methodNamesByInputNames = [];
        foreach ($this->formControlTypeResolvers as $formControlTypeResolver) {
            $currentMethodNamesByInputNames = $formControlTypeResolver->resolve($node);
            $methodNamesByInputNames = \array_merge($methodNamesByInputNames, $currentMethodNamesByInputNames);
        }
        return $methodNamesByInputNames;
    }
}
