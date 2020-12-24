<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Contract\ExpectedNameResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
interface ExpectedNameResolverInterface
{
    /**
     * @param Param|Property $node
     */
    public function resolveIfNotYet(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string;
    /**
     * @param Param|Property $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string;
}
