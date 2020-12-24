<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\ReadWrite\ReadNodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedYetException;
use _PhpScoper0a6b37af0871\Rector\Core\NodeFinder\NodeUsageFinder;
use _PhpScoper0a6b37af0871\Rector\NodeNestingScope\ParentScopeFinder;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function autowireAbstractReadNodeAnalyzer(\_PhpScoper0a6b37af0871\Rector\NodeNestingScope\ParentScopeFinder $parentScopeFinder, \_PhpScoper0a6b37af0871\Rector\Core\NodeFinder\NodeUsageFinder $nodeUsageFinder) : void
    {
        $this->parentScopeFinder = $parentScopeFinder;
        $this->nodeUsageFinder = $nodeUsageFinder;
    }
    protected function isCurrentContextRead(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : bool
    {
        $parent = $expr->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_) {
            return \true;
        }
        if ($parent instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Arg) {
            return \true;
        }
        if ($parent instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch) {
            $parentParent = $parent->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$parentParent instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
                return \true;
            }
            return $parentParent->var !== $parent;
        }
        throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedYetException();
    }
}
