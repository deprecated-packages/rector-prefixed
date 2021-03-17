<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\Contract;

use Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
interface MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @param \Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver
     */
    public function setResolver($methodNamesByInputNamesResolver) : void;
}
