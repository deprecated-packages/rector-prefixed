<?php

declare (strict_types=1);
namespace Rector\Nette\Contract;

use Rector\Nette\NodeResolver\MethodNamesByInputNamesResolver;
interface MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @return void
     * @param \Rector\Nette\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver
     */
    public function setResolver($methodNamesByInputNamesResolver);
}
