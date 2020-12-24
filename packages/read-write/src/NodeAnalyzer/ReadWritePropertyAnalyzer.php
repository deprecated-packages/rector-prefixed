<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\ReadWrite\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PostDec;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PostInc;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PreDec;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PreInc;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScopere8e811afab72\Rector\Core\Exception\Node\MissingParentNodeException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\AssignManipulator;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\SOLID\Guard\VariableToConstantGuard;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\SOLID\Guard\VariableToConstantGuard $variableToConstantGuard, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\AssignManipulator $assignManipulator, \_PhpScopere8e811afab72\Rector\ReadWrite\NodeAnalyzer\ReadExprAnalyzer $readExprAnalyzer)
    {
        $this->variableToConstantGuard = $variableToConstantGuard;
        $this->assignManipulator = $assignManipulator;
        $this->readExprAnalyzer = $readExprAnalyzer;
    }
    /**
     * @param PropertyFetch|StaticPropertyFetch $node
     */
    public function isRead(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::isAnyOf($node, [\_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch::class]);
        $parent = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\Node\MissingParentNodeException();
        }
        $parent = $this->unwrapPostPreIncDec($parent);
        if ($parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Arg) {
            $readArg = $this->variableToConstantGuard->isReadArg($parent);
            if ($readArg) {
                return \true;
            }
        }
        if ($parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch && $parent->dim === $node) {
            return $this->isArrayDimFetchRead($parent);
        }
        return !$this->assignManipulator->isLeftPartOfAssign($node);
    }
    private function unwrapPostPreIncDec(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PreInc || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PreDec || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PostInc || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PostDec) {
            $node = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($node === null) {
                throw new \_PhpScopere8e811afab72\Rector\Core\Exception\Node\MissingParentNodeException();
            }
        }
        return $node;
    }
    private function isArrayDimFetchRead(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : bool
    {
        $parentParent = $arrayDimFetch->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentParent === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\Node\MissingParentNodeException();
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
