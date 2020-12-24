<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeNameResolver\Contract;

use _PhpScoperb75b35f52b74\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function getNode() : string;
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string;
}
