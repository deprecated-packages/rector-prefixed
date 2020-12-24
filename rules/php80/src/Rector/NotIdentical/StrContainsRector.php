<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php80\Rector\NotIdentical;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://externals.io/message/108562
 * @see https://github.com/php/php-src/pull/5179
 *
 * @see \Rector\Php80\Tests\Rector\NotIdentical\StrContainsRector\StrContainsRectorTest
 */
final class StrContainsRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const OLD_STR_NAMES = ['strpos', 'strstr'];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace strpos() !== false and strstr()  with str_contains()', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param NotIdentical $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $funcCall = $this->matchNotIdenticalToFalse($node);
        if ($funcCall === null) {
            return null;
        }
        $funcCall->name = new \_PhpScopere8e811afab72\PhpParser\Node\Name('str_contains');
        return $funcCall;
    }
    /**
     * @return FuncCall|null
     */
    private function matchNotIdenticalToFalse(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical $notIdentical) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
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
