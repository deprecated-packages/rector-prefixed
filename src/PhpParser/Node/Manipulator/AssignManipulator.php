<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\List_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PostDec;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PostInc;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PreDec;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PreInc;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class AssignManipulator
{
    /**
     * @var string[]
     */
    private const MODIFYING_NODES = [\_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\PreDec::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\PostDec::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\PreInc::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\PostInc::class];
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer $propertyFetchAnalyzer)
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
    public function isListToEachAssign(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) : bool
    {
        if (!$assign->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        if (!$assign->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\List_) {
            return \false;
        }
        return $this->nodeNameResolver->isName($assign->expr, 'each');
    }
    public function isLeftPartOfAssign(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        $parentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign && $parentNode->var === $node) {
            return \true;
        }
        if ($parentNode !== null && $this->isValueModifyingNode($parentNode)) {
            return \true;
        }
        // traverse up to array dim fetches
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            $previousParentNode = $parentNode;
            while ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
                $previousParentNode = $parentNode;
                $parentNode = $parentNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            }
            if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return $parentNode->var === $previousParentNode;
            }
        }
        return \false;
    }
    public function isNodePartOfAssign(?\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        if ($node === null) {
            return \false;
        }
        $previousNode = $node;
        $parentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        while ($parentNode !== null && !$parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
            if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign && $this->betterStandardPrinter->areNodesEqual($parentNode->var, $previousNode)) {
                return \true;
            }
            $previousNode = $parentNode;
            $parentNode = $parentNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        return \false;
    }
    /**
     * @return PropertyFetch[]
     */
    public function resolveAssignsToLocalPropertyFetches(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : array
    {
        return $this->betterNodeFinder->find((array) $functionLike->getStmts(), function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            if (!$this->propertyFetchAnalyzer->isLocalPropertyFetch($node)) {
                return \false;
            }
            return $this->isLeftPartOfAssign($node);
        });
    }
    private function isValueModifyingNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
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
