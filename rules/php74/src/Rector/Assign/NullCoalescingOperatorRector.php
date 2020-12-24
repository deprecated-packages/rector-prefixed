<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php74\Rector\Assign;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignOp\Coalesce as AssignCoalesce;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/null_coalesce_equal_operator
 * @see \Rector\Php74\Tests\Rector\Assign\NullCoalescingOperatorRector\NullCoalescingOperatorRectorTest
 */
final class NullCoalescingOperatorRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use null coalescing operator ??=', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$array = [];
$array['user_id'] = $array['user_id'] ?? 'value';
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$array = [];
$array['user_id'] ??= 'value';
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature::NULL_COALESCE_ASSIGN)) {
            return null;
        }
        if (!$node->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Coalesce) {
            return null;
        }
        if (!$this->areNodesEqual($node->var, $node->expr->left)) {
            return null;
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignOp\Coalesce($node->var, $node->expr->right);
    }
}
