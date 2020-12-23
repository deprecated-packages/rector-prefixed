<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\ReadWrite\NodeAnalyzer;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PostDec;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PostInc;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreDec;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreInc;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\Node\MissingParentNodeException;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\AssignManipulator;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\SOLID\Guard\VariableToConstantGuard;
use _PhpScoper0a2ac50786fa\Webmozart\Assert\Assert;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\SOLID\Guard\VariableToConstantGuard $variableToConstantGuard, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\AssignManipulator $assignManipulator, \_PhpScoper0a2ac50786fa\Rector\ReadWrite\NodeAnalyzer\ReadExprAnalyzer $readExprAnalyzer)
    {
        $this->variableToConstantGuard = $variableToConstantGuard;
        $this->assignManipulator = $assignManipulator;
        $this->readExprAnalyzer = $readExprAnalyzer;
    }
    /**
     * @param PropertyFetch|StaticPropertyFetch $node
     */
    public function isRead(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        \_PhpScoper0a2ac50786fa\Webmozart\Assert\Assert::isAnyOf($node, [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch::class]);
        $parent = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent === null) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\Node\MissingParentNodeException();
        }
        $parent = $this->unwrapPostPreIncDec($parent);
        if ($parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg) {
            $readArg = $this->variableToConstantGuard->isReadArg($parent);
            if ($readArg) {
                return \true;
            }
        }
        if ($parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch && $parent->dim === $node) {
            return $this->isArrayDimFetchRead($parent);
        }
        return !$this->assignManipulator->isLeftPartOfAssign($node);
    }
    private function unwrapPostPreIncDec(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : \_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreInc || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreDec || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PostInc || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PostDec) {
            $node = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($node === null) {
                throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\Node\MissingParentNodeException();
            }
        }
        return $node;
    }
    private function isArrayDimFetchRead(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : bool
    {
        $parentParent = $arrayDimFetch->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentParent === null) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\Node\MissingParentNodeException();
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
