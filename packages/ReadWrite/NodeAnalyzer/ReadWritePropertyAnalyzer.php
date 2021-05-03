<?php

declare (strict_types=1);
namespace Rector\ReadWrite\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Isset_;
use PhpParser\Node\Expr\PostDec;
use PhpParser\Node\Expr\PostInc;
use PhpParser\Node\Expr\PreDec;
use PhpParser\Node\Expr\PreInc;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Stmt\Unset_;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\NodeManipulator\AssignManipulator;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\ReadWrite\Guard\VariableToConstantGuard;
use RectorPrefix20210503\Webmozart\Assert\Assert;
final class ReadWritePropertyAnalyzer
{
    /**
     * @var VariableToConstantGuard
     */
    private $variableToConstantGuard;
    /**
     * @var AssignManipulator
     */
    private $assignManipulator;
    /**
     * @var ReadExprAnalyzer
     */
    private $readExprAnalyzer;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\Rector\ReadWrite\Guard\VariableToConstantGuard $variableToConstantGuard, \Rector\Core\NodeManipulator\AssignManipulator $assignManipulator, \Rector\ReadWrite\NodeAnalyzer\ReadExprAnalyzer $readExprAnalyzer, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->variableToConstantGuard = $variableToConstantGuard;
        $this->assignManipulator = $assignManipulator;
        $this->readExprAnalyzer = $readExprAnalyzer;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    /**
     * @param PropertyFetch|StaticPropertyFetch $node
     */
    public function isRead(\PhpParser\Node $node) : bool
    {
        \RectorPrefix20210503\Webmozart\Assert\Assert::isAnyOf($node, [\PhpParser\Node\Expr\PropertyFetch::class, \PhpParser\Node\Expr\StaticPropertyFetch::class]);
        $parent = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parent instanceof \PhpParser\Node) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $parent = $this->unwrapPostPreIncDec($parent);
        if ($parent instanceof \PhpParser\Node\Arg) {
            $readArg = $this->variableToConstantGuard->isReadArg($parent);
            if ($readArg) {
                return \true;
            }
        }
        if ($parent instanceof \PhpParser\Node\Expr\ArrayDimFetch && $parent->dim === $node && $this->isNotInsideIssetUnset($parent)) {
            return $this->isArrayDimFetchRead($parent);
        }
        return !$this->assignManipulator->isLeftPartOfAssign($node);
    }
    private function unwrapPostPreIncDec(\PhpParser\Node $node) : \PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Expr\PreInc || $node instanceof \PhpParser\Node\Expr\PreDec || $node instanceof \PhpParser\Node\Expr\PostInc || $node instanceof \PhpParser\Node\Expr\PostDec) {
            $node = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$node instanceof \PhpParser\Node) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
        }
        return $node;
    }
    private function isNotInsideIssetUnset(\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : bool
    {
        return !(bool) $this->betterNodeFinder->findParentTypes($arrayDimFetch, [\PhpParser\Node\Expr\Isset_::class, \PhpParser\Node\Stmt\Unset_::class]);
    }
    private function isArrayDimFetchRead(\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : bool
    {
        $parentParent = $arrayDimFetch->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentParent instanceof \PhpParser\Node) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        if (!$this->assignManipulator->isLeftPartOfAssign($arrayDimFetch)) {
            return \false;
        }
        if ($arrayDimFetch->var instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            return \true;
        }
        // the array dim fetch is assing here only; but the variable might be used later
        if ($this->readExprAnalyzer->isExprRead($arrayDimFetch->var)) {
            return \true;
        }
        return !$this->assignManipulator->isLeftPartOfAssign($arrayDimFetch);
    }
}
