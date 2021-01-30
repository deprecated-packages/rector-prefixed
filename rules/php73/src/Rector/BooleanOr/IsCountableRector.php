<?php

declare (strict_types=1);
namespace Rector\Php73\Rector\BooleanOr;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\Php71\IsArrayAndDualCheckToAble;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Php73\Tests\Rector\BinaryOr\IsCountableRector\IsCountableRectorTest
 */
final class IsCountableRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var IsArrayAndDualCheckToAble
     */
    private $isArrayAndDualCheckToAble;
    public function __construct(\Rector\Php71\IsArrayAndDualCheckToAble $isArrayAndDualCheckToAble)
    {
        $this->isArrayAndDualCheckToAble = $isArrayAndDualCheckToAble;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes is_array + Countable check to is_countable', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
is_array($foo) || $foo instanceof Countable;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
is_countable($foo);
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\BinaryOp\BooleanOr::class];
    }
    /**
     * @param BooleanOr $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->shouldSkip()) {
            return null;
        }
        return $this->isArrayAndDualCheckToAble->processBooleanOr($node, 'Countable', 'is_countable') ?: $node;
    }
    private function shouldSkip() : bool
    {
        if (\function_exists('is_countable')) {
            return \false;
        }
        return $this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::IS_COUNTABLE);
    }
}
