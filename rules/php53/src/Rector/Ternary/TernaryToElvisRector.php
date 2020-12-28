<?php

declare (strict_types=1);
namespace Rector\Php53\Rector\Ternary;

use PhpParser\Node;
use PhpParser\Node\Expr\Ternary;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see http://php.net/manual/en/language.operators.comparison.php#language.operators.comparison.ternary
 * @see https://stackoverflow.com/a/1993455/1348344
 * @see \Rector\Php53\Tests\Rector\Ternary\TernaryToElvisRector\TernaryToElvisRectorTest
 */
final class TernaryToElvisRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use ?: instead of ?, where useful', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
function elvis()
{
    $value = $a ? $a : false;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
function elvis()
{
    $value = $a ?: false;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param Ternary $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::ELVIS_OPERATOR)) {
            return null;
        }
        if (!$this->areNodesEqual($node->cond, $node->if)) {
            return null;
        }
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
        $node->if = null;
        return $node;
    }
}
