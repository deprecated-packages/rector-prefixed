<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Contract;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
interface FormControlTypeResolverInterface
{
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : array;
}
