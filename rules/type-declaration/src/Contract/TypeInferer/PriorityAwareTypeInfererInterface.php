<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Contract\TypeInferer;

interface PriorityAwareTypeInfererInterface
{
    /**
     * Higher priority goes first.
     */
    public function getPriority() : int;
}
