<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeNameResolver\Contract;

use _PhpScopere8e811afab72\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function getNode() : string;
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string;
}
