<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PSR4\Contract;

use _PhpScoperb75b35f52b74\PhpParser\Node;
interface PSR4AutoloadNamespaceMatcherInterface
{
    public function getExpectedNamespace(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string;
}
