<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer;

interface PriorityAwareTypeInfererInterface
{
    /**
     * Higher priority goes first.
     */
    public function getPriority() : int;
}
