<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\Rector\Identical;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Identical\StrlenZeroToIdenticalEmptyStringRector\StrlenZeroToIdenticalEmptyStringRectorTest
 */
final class StrlenZeroToIdenticalEmptyStringRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes strlen comparison to 0 to direct empty string compare', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($value)
    {
        $empty = strlen($value) === 0;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($value)
    {
        $empty = $value === '';
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical::class];
    }
    /**
     * @param Identical $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $variable = null;
        if ($node->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
            if (!$this->isName($node->left, 'strlen')) {
                return null;
            }
            if (!$this->isValue($node->right, 0)) {
                return null;
            }
            $variable = $node->left->args[0]->value;
        } elseif ($node->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
            if (!$this->isName($node->right, 'strlen')) {
                return null;
            }
            if (!$this->isValue($node->left, 0)) {
                return null;
            }
            $variable = $node->right->args[0]->value;
        } else {
            return null;
        }
        /** @var Expr $variable */
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical($variable, new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_(''));
    }
}
