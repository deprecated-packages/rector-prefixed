<?php

declare (strict_types=1);
namespace Rector\Php80\Rector\Assign;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Cast\Int_;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Php80\Tests\Rector\Assign\FalseableCountToZeroRector\FalseableCountToZeroRectorTest
 */
final class FalseableCountToZeroRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Convert false of pg_num_rows() to zero', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $value = pg_num_rows('...');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $value = (int) pg_num_rows('...');
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
        return [\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isFuncCallName($node->expr, 'pg_num_rows')) {
            return null;
        }
        $node->expr = new \PhpParser\Node\Expr\Cast\Int_($node->expr);
        return $node;
    }
}
