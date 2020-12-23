<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\Rector\FuncCall;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\FuncCall\AddPregQuoteDelimiterRector\AddPregQuoteDelimiterRectorTest
 */
final class AddPregQuoteDelimiterRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     * @see https://www.php.net/manual/en/reference.pcre.pattern.modifiers.php
     */
    private const ALL_MODIFIERS = 'imsxeADSUXJu';
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add preg_quote delimiter when missing', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
'#' . preg_quote('name') . '#';
CODE_SAMPLE
, <<<'CODE_SAMPLE'
'#' . preg_quote('name', '#') . '#';
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->isName($node, 'preg_quote')) {
            return null;
        }
        // already completed
        if (isset($node->args[1])) {
            return null;
        }
        $delimiter = $this->determineDelimiter($node);
        if ($delimiter === null) {
            return null;
        }
        $node->args[1] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($delimiter));
        return $node;
    }
    private function determineDelimiter(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $funcCall) : ?string
    {
        $concat = $this->getUppermostConcat($funcCall);
        if ($concat === null) {
            return null;
        }
        $leftMostConcatNode = $concat->left;
        while ($leftMostConcatNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat) {
            $leftMostConcatNode = $leftMostConcatNode->left;
        }
        $rightMostConcatNode = $concat->right;
        while ($rightMostConcatNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat) {
            $rightMostConcatNode = $rightMostConcatNode->right;
        }
        if (!$leftMostConcatNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_) {
            return null;
        }
        $possibleLeftDelimiter = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::substring($leftMostConcatNode->value, 0, 1);
        if (!$rightMostConcatNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_) {
            return null;
        }
        $possibleRightDelimiter = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::substring(\rtrim($rightMostConcatNode->value, self::ALL_MODIFIERS), -1, 1);
        if ($possibleLeftDelimiter === $possibleRightDelimiter) {
            return $possibleLeftDelimiter;
        }
        return null;
    }
    private function getUppermostConcat(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $funcCall) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat
    {
        $upperMostConcat = null;
        $parent = $funcCall->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        while ($parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat) {
            $upperMostConcat = $parent;
            $parent = $parent->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        return $upperMostConcat;
    }
}
