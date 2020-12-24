<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\ReadWrite\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PostDec;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PostInc;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreDec;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreInc;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\Node\MissingParentNodeException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\AssignManipulator;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\SOLID\Guard\VariableToConstantGuard;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\SOLID\Guard\VariableToConstantGuard $variableToConstantGuard, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\AssignManipulator $assignManipulator, \_PhpScoperb75b35f52b74\Rector\ReadWrite\NodeAnalyzer\ReadExprAnalyzer $readExprAnalyzer)
    {
        $this->variableToConstantGuard = $variableToConstantGuard;
        $this->assignManipulator = $assignManipulator;
        $this->readExprAnalyzer = $readExprAnalyzer;
    }
    /**
     * @param PropertyFetch|StaticPropertyFetch $node
     */
    public function isRead(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::isAnyOf($node, [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch::class]);
        $parent = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\Node\MissingParentNodeException();
        }
        $parent = $this->unwrapPostPreIncDec($parent);
        if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Arg) {
            $readArg = $this->variableToConstantGuard->isReadArg($parent);
            if ($readArg) {
                return \true;
            }
        }
        if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch && $parent->dim === $node) {
            return $this->isArrayDimFetchRead($parent);
        }
        return !$this->assignManipulator->isLeftPartOfAssign($node);
    }
    private function unwrapPostPreIncDec(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreInc || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreDec || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PostInc || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PostDec) {
            $node = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($node === null) {
                throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\Node\MissingParentNodeException();
            }
        }
        return $node;
    }
    private function isArrayDimFetchRead(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : bool
    {
        $parentParent = $arrayDimFetch->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentParent === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\Node\MissingParentNodeException();
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
