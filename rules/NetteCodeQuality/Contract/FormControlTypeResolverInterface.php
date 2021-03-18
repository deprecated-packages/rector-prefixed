<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\Contract;

use PhpParser\Node;
interface FormControlTypeResolverInterface
{
    /**
     * @return array<string, class-string>
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : array;
}
