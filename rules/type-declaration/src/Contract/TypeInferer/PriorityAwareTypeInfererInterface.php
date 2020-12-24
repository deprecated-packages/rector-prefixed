<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer;

interface PriorityAwareTypeInfererInterface
{
    /**
     * Higher priority goes first.
     */
    public function getPriority() : int;
}
