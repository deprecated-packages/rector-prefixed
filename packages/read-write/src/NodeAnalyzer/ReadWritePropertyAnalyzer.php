<?php

declare (strict_types=1);
namespace Rector\ReadWrite\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\PostDec;
use PhpParser\Node\Expr\PostInc;
use PhpParser\Node\Expr\PreDec;
use PhpParser\Node\Expr\PreInc;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticPropertyFetch;
use Rector\Core\Exception\Node\MissingParentNodeException;
use Rector\Core\PhpParser\Node\Manipulator\AssignManipulator;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\ReadWrite\Guard\VariableToConstantGuard;
use _PhpScoper17db12703726\Webmozart\Assert\Assert;
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
    public function __construct(\Rector\ReadWrite\Guard\VariableToConstantGuard $variableToConstantGuard, \Rector\Core\PhpParser\Node\Manipulator\AssignManipulator $assignManipulator, \Rector\ReadWrite\NodeAnalyzer\ReadExprAnalyzer $readExprAnalyzer)
    {
        $this->variableToConstantGuard = $variableToConstantGuard;
        $this->assignManipulator = $assignManipulator;
        $this->readExprAnalyzer = $readExprAnalyzer;
    }
    /**
     * @param PropertyFetch|StaticPropertyFetch $node
     */
    public function isRead(\PhpParser\Node $node) : bool
    {
        \_PhpScoper17db12703726\Webmozart\Assert\Assert::isAnyOf($node, [\PhpParser\Node\Expr\PropertyFetch::class, \PhpParser\Node\Expr\StaticPropertyFetch::class]);
        $parent = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent === null) {
            throw new \Rector\Core\Exception\Node\MissingParentNodeException();
        }
        $parent = $this->unwrapPostPreIncDec($parent);
        if ($parent instanceof \PhpParser\Node\Arg) {
            $readArg = $this->variableToConstantGuard->isReadArg($parent);
            if ($readArg) {
                return \true;
            }
        }
        if ($parent instanceof \PhpParser\Node\Expr\ArrayDimFetch && $parent->dim === $node) {
            return $this->isArrayDimFetchRead($parent);
        }
        return !$this->assignManipulator->isLeftPartOfAssign($node);
    }
    private function unwrapPostPreIncDec(\PhpParser\Node $node) : \PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Expr\PreInc || $node instanceof \PhpParser\Node\Expr\PreDec || $node instanceof \PhpParser\Node\Expr\PostInc || $node instanceof \PhpParser\Node\Expr\PostDec) {
            $node = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($node === null) {
                throw new \Rector\Core\Exception\Node\MissingParentNodeException();
            }
        }
        return $node;
    }
    private function isArrayDimFetchRead(\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : bool
    {
        $parentParent = $arrayDimFetch->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentParent === null) {
            throw new \Rector\Core\Exception\Node\MissingParentNodeException();
        }
        if (!$this->assignManipulator->isLeftPartOfAssign($arrayDimFetch)) {
            return \false;
        }
        // the array dim fetch is assing here only; but the variable might be used later
        if ($this->readExprAnalyzer->isExprRead($arrayDimFetch->var)) {
            return \true;
        }
        return !$this->assignManipulator->isLeftPartOfAssign($arrayDimFetch);
    }
}
