<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\Rector\Concat;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Concat\JoinStringConcatRector\JoinStringConcatRectorTest
 */
final class JoinStringConcatRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var int
     */
    private const LINE_BREAK_POINT = 100;
    /**
     * @var bool
     */
    private $nodeReplacementIsRestricted = \false;
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Joins concat of 2 strings, unless the lenght is too long', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat::class];
    }
    /**
     * @param Concat $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $this->nodeReplacementIsRestricted = \false;
        if (!$this->isTopMostConcatNode($node)) {
            return null;
        }
        $joinedNode = $this->joinConcatIfStrings($node);
        if (!$joinedNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_) {
            return null;
        }
        if ($this->nodeReplacementIsRestricted) {
            return null;
        }
        return $joinedNode;
    }
    private function isTopMostConcatNode(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat $concat) : bool
    {
        return !$concat->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE) instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat;
    }
    /**
     * @return Concat|String_
     */
    private function joinConcatIfStrings(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat $node) : \_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $concat = clone $node;
        if ($concat->left instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat) {
            $concat->left = $this->joinConcatIfStrings($concat->left);
        }
        if ($concat->right instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat) {
            $concat->right = $this->joinConcatIfStrings($concat->right);
        }
        if (!$concat->left instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_) {
            return $node;
        }
        if (!$concat->right instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_) {
            return $node;
        }
        $resultString = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($concat->left->value . $concat->right->value);
        if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::length($resultString->value) >= self::LINE_BREAK_POINT) {
            $this->nodeReplacementIsRestricted = \true;
            return $node;
        }
        return $resultString;
    }
}
