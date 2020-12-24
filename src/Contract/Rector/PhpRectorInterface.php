<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Contract\Rector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\NodeVisitor;
interface PhpRectorInterface extends \_PhpScopere8e811afab72\PhpParser\NodeVisitor, \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\RectorInterface
{
    /**
     * List of nodes this class checks, classes that implements \PhpParser\Node
     * See beautiful map of all nodes https://github.com/rectorphp/rector/blob/master/docs/nodes_overview.md
     *
     * @return class-string[]
     */
    public function getNodeTypes() : array;
    /**
     * Process Node of matched type
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node;
}
