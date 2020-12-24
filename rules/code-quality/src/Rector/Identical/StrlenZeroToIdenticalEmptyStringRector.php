<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\Identical;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Identical\StrlenZeroToIdenticalEmptyStringRector\StrlenZeroToIdenticalEmptyStringRectorTest
 */
final class StrlenZeroToIdenticalEmptyStringRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes strlen comparison to 0 to direct empty string compare', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical::class];
    }
    /**
     * @param Identical $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $variable = null;
        if ($node->left instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            if (!$this->isName($node->left, 'strlen')) {
                return null;
            }
            if (!$this->isValue($node->right, 0)) {
                return null;
            }
            $variable = $node->left->args[0]->value;
        } elseif ($node->right instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
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
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical($variable, new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_(''));
    }
}
