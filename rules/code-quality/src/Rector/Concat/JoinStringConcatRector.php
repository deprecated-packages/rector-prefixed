<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\Concat;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Concat\JoinStringConcatRector\JoinStringConcatRectorTest
 */
final class JoinStringConcatRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var int
     */
    private const LINE_BREAK_POINT = 100;
    /**
     * @var bool
     */
    private $nodeReplacementIsRestricted = \false;
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Joins concat of 2 strings, unless the lenght is too long', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $name = 'Hi' . ' Tom';
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $name = 'Hi Tom';
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat::class];
    }
    /**
     * @param Concat $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $this->nodeReplacementIsRestricted = \false;
        if (!$this->isTopMostConcatNode($node)) {
            return null;
        }
        $joinedNode = $this->joinConcatIfStrings($node);
        if (!$joinedNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return null;
        }
        if ($this->nodeReplacementIsRestricted) {
            return null;
        }
        return $joinedNode;
    }
    private function isTopMostConcatNode(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat $concat) : bool
    {
        return !$concat->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE) instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat;
    }
    /**
     * @return Concat|String_
     */
    private function joinConcatIfStrings(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat $node) : \_PhpScopere8e811afab72\PhpParser\Node
    {
        $concat = clone $node;
        if ($concat->left instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat) {
            $concat->left = $this->joinConcatIfStrings($concat->left);
        }
        if ($concat->right instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat) {
            $concat->right = $this->joinConcatIfStrings($concat->right);
        }
        if (!$concat->left instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return $node;
        }
        if (!$concat->right instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return $node;
        }
        $resultString = new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_($concat->left->value . $concat->right->value);
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::length($resultString->value) >= self::LINE_BREAK_POINT) {
            $this->nodeReplacementIsRestricted = \true;
            return $node;
        }
        return $resultString;
    }
}
