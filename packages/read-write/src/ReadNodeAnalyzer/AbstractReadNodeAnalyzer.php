<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\ReadWrite\ReadNodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedYetException;
use _PhpScoperb75b35f52b74\Rector\Core\NodeFinder\NodeUsageFinder;
use _PhpScoperb75b35f52b74\Rector\NodeNestingScope\ParentScopeFinder;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function autowireAbstractReadNodeAnalyzer(\_PhpScoperb75b35f52b74\Rector\NodeNestingScope\ParentScopeFinder $parentScopeFinder, \_PhpScoperb75b35f52b74\Rector\Core\NodeFinder\NodeUsageFinder $nodeUsageFinder) : void
    {
        $this->parentScopeFinder = $parentScopeFinder;
        $this->nodeUsageFinder = $nodeUsageFinder;
    }
    protected function isCurrentContextRead(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        $parent = $expr->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
            return \true;
        }
        if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Arg) {
            return \true;
        }
        if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch) {
            $parentParent = $parent->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$parentParent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
                return \true;
            }
            return $parentParent->var !== $parent;
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedYetException();
    }
}
