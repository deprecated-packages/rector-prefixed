<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php80\Rector\NotIdentical;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://externals.io/message/108562
 * @see https://github.com/php/php-src/pull/5179
 *
 * @see \Rector\Php80\Tests\Rector\NotIdentical\StrContainsRector\StrContainsRectorTest
 */
final class StrContainsRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const OLD_STR_NAMES = ['strpos', 'strstr'];
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace strpos() !== false and strstr()  with str_contains()', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param NotIdentical $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $funcCall = $this->matchNotIdenticalToFalse($node);
        if ($funcCall === null) {
            return null;
        }
        $funcCall->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('str_contains');
        return $funcCall;
    }
    /**
     * @return FuncCall|null
     */
    private function matchNotIdenticalToFalse(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical $notIdentical) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
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
