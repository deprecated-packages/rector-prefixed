<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\ReadWrite\NodeAnalyzer;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PostDec;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PostInc;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PreDec;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PreInc;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\Node\MissingParentNodeException;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\AssignManipulator;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\SOLID\Guard\VariableToConstantGuard;
use _PhpScoper2a4e7ab1ecbc\Webmozart\Assert\Assert;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\SOLID\Guard\VariableToConstantGuard $variableToConstantGuard, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\AssignManipulator $assignManipulator, \_PhpScoper2a4e7ab1ecbc\Rector\ReadWrite\NodeAnalyzer\ReadExprAnalyzer $readExprAnalyzer)
    {
        $this->variableToConstantGuard = $variableToConstantGuard;
        $this->assignManipulator = $assignManipulator;
        $this->readExprAnalyzer = $readExprAnalyzer;
    }
    /**
     * @param PropertyFetch|StaticPropertyFetch $node
     */
    public function isRead(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        \_PhpScoper2a4e7ab1ecbc\Webmozart\Assert\Assert::isAnyOf($node, [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticPropertyFetch::class]);
        $parent = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent === null) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\Node\MissingParentNodeException();
        }
        $parent = $this->unwrapPostPreIncDec($parent);
        if ($parent instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg) {
            $readArg = $this->variableToConstantGuard->isReadArg($parent);
            if ($readArg) {
                return \true;
            }
        }
        if ($parent instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch && $parent->dim === $node) {
            return $this->isArrayDimFetchRead($parent);
        }
        return !$this->assignManipulator->isLeftPartOfAssign($node);
    }
    private function unwrapPostPreIncDec(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PreInc || $node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PreDec || $node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PostInc || $node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PostDec) {
            $node = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($node === null) {
                throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\Node\MissingParentNodeException();
            }
        }
        return $node;
    }
    private function isArrayDimFetchRead(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : bool
    {
        $parentParent = $arrayDimFetch->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentParent === null) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\Node\MissingParentNodeException();
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
