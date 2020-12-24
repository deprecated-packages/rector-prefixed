<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Contract;

use _PhpScoperb75b35f52b74\PhpParser\Node;
interface FormControlTypeResolverInterface
{
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array;
}
