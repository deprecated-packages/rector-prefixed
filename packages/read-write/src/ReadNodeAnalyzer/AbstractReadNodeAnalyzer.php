<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\ReadWrite\ReadNodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedYetException;
use _PhpScopere8e811afab72\Rector\Core\NodeFinder\NodeUsageFinder;
use _PhpScopere8e811afab72\Rector\NodeNestingScope\ParentScopeFinder;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractReadNodeAnalyzer
{
    /**
     * @var ParentScopeFinder
     */
    protected $parentScopeFinder;
    /**
     * @var NodeUsageFinder
     */
    protected $nodeUsageFinder;
    /**
     * @required
     */
    public function autowireAbstractReadNodeAnalyzer(\_PhpScopere8e811afab72\Rector\NodeNestingScope\ParentScopeFinder $parentScopeFinder, \_PhpScopere8e811afab72\Rector\Core\NodeFinder\NodeUsageFinder $nodeUsageFinder) : void
    {
        $this->parentScopeFinder = $parentScopeFinder;
        $this->nodeUsageFinder = $nodeUsageFinder;
    }
    protected function isCurrentContextRead(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : bool
    {
        $parent = $expr->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_) {
            return \true;
        }
        if ($parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Arg) {
            return \true;
        }
        if ($parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            $parentParent = $parent->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$parentParent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return \true;
            }
            return $parentParent->var !== $parent;
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedYetException();
    }
}
