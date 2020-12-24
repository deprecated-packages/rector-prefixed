<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer;

interface PriorityAwareTypeInfererInterface
{
    /**
     * Higher priority goes first.
     */
    public function getPriority() : int;
}
