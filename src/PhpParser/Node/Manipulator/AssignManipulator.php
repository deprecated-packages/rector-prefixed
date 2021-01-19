<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Node\Manipulator;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\AssignOp;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\List_;
use PhpParser\Node\Expr\PostDec;
use PhpParser\Node\Expr\PostInc;
use PhpParser\Node\Expr\PreDec;
use PhpParser\Node\Expr\PreInc;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class AssignManipulator
{
    /**
     * @var string[]
     */
    private const MODIFYING_NODES = [\PhpParser\Node\Expr\AssignOp::class, \PhpParser\Node\Expr\PreDec::class, \PhpParser\Node\Expr\PostDec::class, \PhpParser\Node\Expr\PreInc::class, \PhpParser\Node\Expr\PostInc::class];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var PropertyFetchAnalyzer
     */
    private $propertyFetchAnalyzer;
    public function __construct(\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer $propertyFetchAnalyzer)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->propertyFetchAnalyzer = $propertyFetchAnalyzer;
    }
    /**
     * Matches:
     * each() = [1, 2];
     */
    public function isListToEachAssign(\PhpParser\Node\Expr\Assign $assign) : bool
    {
        if (!$assign->expr instanceof \PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        if (!$assign->var instanceof \PhpParser\Node\Expr\List_) {
            return \false;
        }
        return $this->nodeNameResolver->isName($assign->expr, 'each');
    }
    public function isLeftPartOfAssign(\PhpParser\Node $node) : bool
    {
        $parent = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \PhpParser\Node\Expr\Assign && $this->betterStandardPrinter->areNodesEqual($parent->var, $node)) {
            return \true;
        }
        if ($parent !== null && $this->isValueModifyingNode($parent)) {
            return \true;
        }
        // traverse up to array dim fetches
        if ($parent instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            $previousParent = $parent;
            while ($parent instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
                $previousParent = $parent;
                $parent = $parent->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            }
            if ($parent instanceof \PhpParser\Node\Expr\Assign) {
                return $parent->var === $previousParent;
            }
        }
        return \false;
    }
    public function isNodePartOfAssign(\PhpParser\Node $node) : bool
    {
        $previousNode = $node;
        $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        while ($parentNode !== null && !$parentNode instanceof \PhpParser\Node\Stmt\Expression) {
            if ($parentNode instanceof \PhpParser\Node\Expr\Assign && $this->betterStandardPrinter->areNodesEqual($parentNode->var, $previousNode)) {
                return \true;
            }
            $previousNode = $parentNode;
            $parentNode = $parentNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        return \false;
    }
    /**
     * @return PropertyFetch[]
     */
    public function resolveAssignsToLocalPropertyFetches(\PhpParser\Node\FunctionLike $functionLike) : array
    {
        return $this->betterNodeFinder->find((array) $functionLike->getStmts(), function (\PhpParser\Node $node) : bool {
            if (!$this->propertyFetchAnalyzer->isLocalPropertyFetch($node)) {
                return \false;
            }
            return $this->isLeftPartOfAssign($node);
        });
    }
    private function isValueModifyingNode(\PhpParser\Node $node) : bool
    {
        foreach (self::MODIFYING_NODES as $modifyingNode) {
            if (!\is_a($node, $modifyingNode)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
}
