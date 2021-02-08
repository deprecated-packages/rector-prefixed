<?php

declare (strict_types=1);
namespace Rector\Php80\Rector\NotIdentical;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://externals.io/message/108562
 * @see https://github.com/php/php-src/pull/5179
 *
 * @see \Rector\Php80\Tests\Rector\NotIdentical\StrContainsRector\StrContainsRectorTest
 */
final class StrContainsRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const OLD_STR_NAMES = ['strpos', 'strstr'];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace strpos() !== false and strstr()  with str_contains()', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param NotIdentical $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $funcCall = $this->matchNotIdenticalToFalse($node);
        if (!$funcCall instanceof \PhpParser\Node\Expr\FuncCall) {
            return null;
        }
        $funcCall->name = new \PhpParser\Node\Name('str_contains');
        return $funcCall;
    }
    /**
     * @return FuncCall|null
     */
    private function matchNotIdenticalToFalse(\PhpParser\Node\Expr\BinaryOp\NotIdentical $notIdentical) : ?\PhpParser\Node\Expr
    {
        if ($this->valueResolver->isFalse($notIdentical->left)) {
            if (!$this->nodeNameResolver->isFuncCallNames($notIdentical->right, self::OLD_STR_NAMES)) {
                return null;
            }
            return $notIdentical->right;
        }
        if ($this->valueResolver->isFalse($notIdentical->right)) {
            if (!$this->nodeNameResolver->isFuncCallNames($notIdentical->left, self::OLD_STR_NAMES)) {
                return null;
            }
            return $notIdentical->left;
        }
        return null;
    }
}
