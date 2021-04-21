<?php

declare (strict_types=1);
namespace Rector\Nette\Contract;

use PhpParser\Node;
interface FormControlTypeResolverInterface
{
    /**
     * @return array<string, class-string>
     */
    public function resolve(\PhpParser\Node $node) : array;
}
