<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DeadCode\Rector\Concat;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast\String_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\Concat\RemoveConcatAutocastRector\RemoveConcatAutocastRectorTest
 */
final class RemoveConcatAutocastRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove (string) casting when it comes to concat, that does this by default', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeConcatingClass
{
    public function run($value)
    {
        return 'hi ' . (string) $value;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeConcatingClass
{
    public function run($value)
    {
        return 'hi ' . $value;
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
        if (!$node->left instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast\String_ && !$node->right instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast\String_) {
            return null;
        }
        $node->left = $this->removeStringCast($node->left);
        $node->right = $this->removeStringCast($node->right);
        return $node;
    }
    private function removeStringCast(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        return $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast\String_ ? $expr->expr : $expr;
    }
}
