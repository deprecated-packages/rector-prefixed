<?php

declare(strict_types=1);

namespace Rector\Nette\Contract;

use Rector\Nette\NodeResolver\MethodNamesByInputNamesResolver;

interface MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @return void
     */
    public function setResolver(MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver);
}
