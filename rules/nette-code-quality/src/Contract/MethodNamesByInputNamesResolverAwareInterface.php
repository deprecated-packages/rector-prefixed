<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract;

use _PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
interface MethodNamesByInputNamesResolverAwareInterface
{
    public function setResolver(\_PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver) : void;
}
