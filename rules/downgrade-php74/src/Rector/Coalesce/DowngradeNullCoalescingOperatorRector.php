<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DowngradePhp74\Rector\Coalesce;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignOp\Coalesce as AssignCoalesce;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/null_coalesce_equal_operator
 * @see \Rector\DowngradePhp74\Tests\Rector\Coalesce\DowngradeNullCoalescingOperatorRector\DowngradeNullCoalescingOperatorRectorTest
 */
final class DowngradeNullCoalescingOperatorRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove null coalescing operator ??=', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$array = [];
$array['user_id'] ??= 'value';
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$array = [];
$array['user_id'] = $array['user_id'] ?? 'value';
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignOp\Coalesce::class];
    }
    /**
     * @param AssignCoalesce $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign($node->var, new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Coalesce($node->var, $node->expr));
    }
}
