<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Contract\TypeInferer;

interface PriorityAwareTypeInfererInterface
{
    /**
     * Higher priority goes first.
     */
    public function getPriority() : int;
}
