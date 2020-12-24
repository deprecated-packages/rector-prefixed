<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\Expression;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_;
use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/dmHCC
 *
 * @see \Rector\CodeQuality\Tests\Rector\Expression\InlineIfToExplicitIfRector\InlineIfToExplicitIfRectorTest
 */
final class InlineIfToExplicitIfRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change inline if to explicit if', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $userId = null;

        is_null($userId) && $userId = 5;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $userId = null;

        if (is_null($userId)) {
            $userId = 5;
        }
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression::class];
    }
    /**
     * @param Expression $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            return null;
        }
        $booleanAnd = $node->expr;
        $leftStaticType = $this->getStaticType($booleanAnd->left);
        if (!$leftStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType) {
            return null;
        }
        if (!$booleanAnd->right instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return null;
        }
        $if = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_($booleanAnd->left);
        $if->stmts[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($booleanAnd->right);
        return $if;
    }
}
