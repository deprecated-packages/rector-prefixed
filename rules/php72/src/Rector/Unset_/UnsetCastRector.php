<?php

declare (strict_types=1);
namespace Rector\Php72\Rector\Unset_;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Cast\Unset_;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Php72\Tests\Rector\Unset_\UnsetCastRector\UnsetCastRectorTest
 */
final class UnsetCastRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes (unset) cast', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$different = (unset) $value;

$value = (unset) $value;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$different = null;

unset($value);
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\Cast\Unset_::class, \PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Unset_|Assign $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Expr\Assign) {
            if ($node->expr instanceof \PhpParser\Node\Expr\Cast\Unset_) {
                $unset = $node->expr;
                if ($this->nodeComparator->areNodesEqual($node->var, $unset->expr)) {
                    return $this->nodeFactory->createFuncCall('unset', [$node->var]);
                }
            }
            return null;
        }
        $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \PhpParser\Node\Stmt\Expression) {
            $this->removeNode($node);
            return null;
        }
        return $this->nodeFactory->createNull();
    }
}
