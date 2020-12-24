<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php80\Rector\NotIdentical;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://externals.io/message/108562
 * @see https://github.com/php/php-src/pull/5179
 *
 * @see \Rector\Php80\Tests\Rector\NotIdentical\StrContainsRector\StrContainsRectorTest
 */
final class StrContainsRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const OLD_STR_NAMES = ['strpos', 'strstr'];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace strpos() !== false and strstr()  with str_contains()', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return strpos('abc', 'a') !== false;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return str_contains('abc', 'a');
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param NotIdentical $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $funcCall = $this->matchNotIdenticalToFalse($node);
        if ($funcCall === null) {
            return null;
        }
        $funcCall->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('str_contains');
        return $funcCall;
    }
    /**
     * @return FuncCall|null
     */
    private function matchNotIdenticalToFalse(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical $notIdentical) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if ($this->isFalse($notIdentical->left)) {
            if (!$this->isFuncCallNames($notIdentical->right, self::OLD_STR_NAMES)) {
                return null;
            }
            return $notIdentical->right;
        }
        if ($this->isFalse($notIdentical->right)) {
            if (!$this->isFuncCallNames($notIdentical->left, self::OLD_STR_NAMES)) {
                return null;
            }
            return $notIdentical->left;
        }
        return null;
    }
}
