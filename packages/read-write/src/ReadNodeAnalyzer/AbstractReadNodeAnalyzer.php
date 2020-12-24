<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\ReadWrite\ReadNodeAnalyzer;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\NotImplementedYetException;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\NodeFinder\NodeUsageFinder;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNestingScope\ParentScopeFinder;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function autowireAbstractReadNodeAnalyzer(\_PhpScoper2a4e7ab1ecbc\Rector\NodeNestingScope\ParentScopeFinder $parentScopeFinder, \_PhpScoper2a4e7ab1ecbc\Rector\Core\NodeFinder\NodeUsageFinder $nodeUsageFinder) : void
    {
        $this->parentScopeFinder = $parentScopeFinder;
        $this->nodeUsageFinder = $nodeUsageFinder;
    }
    protected function isCurrentContextRead(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expr) : bool
    {
        $parent = $expr->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_) {
            return \true;
        }
        if ($parent instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg) {
            return \true;
        }
        if ($parent instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch) {
            $parentParent = $parent->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$parentParent instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign) {
                return \true;
            }
            return $parentParent->var !== $parent;
        }
        throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\NotImplementedYetException();
    }
}
