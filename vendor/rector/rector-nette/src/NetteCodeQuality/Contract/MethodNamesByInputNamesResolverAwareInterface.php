<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\Contract;

use Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
interface MethodNamesByInputNamesResolverAwareInterface
{
    public function setResolver(\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver) : void;
}
