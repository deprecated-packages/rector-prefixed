<?php

declare (strict_types=1);
namespace Rector\DeadDocBlock\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Rector\AbstractRector;
use Rector\DeadDocBlock\TagRemover\ReturnTagRemover;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadDocBlock\Tests\Rector\ClassMethod\RemoveUselessReturnTagRector\RemoveUselessReturnTagRectorTest
 */
final class RemoveUselessReturnTagRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ReturnTagRemover
     */
    private $returnTagRemover;
    public function __construct(\Rector\DeadDocBlock\TagRemover\ReturnTagRemover $returnTagRemover)
    {
        $this->returnTagRemover = $returnTagRemover;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove @return docblock with same type as defined in PHP', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use stdClass;

class SomeClass
{
    /**
     * @return stdClass
     */
    public function foo(): stdClass
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use stdClass;

class SomeClass
{
    public function foo(): stdClass
    {
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
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        $this->returnTagRemover->removeReturnTagIfUseless($phpDocInfo, $node);
        if ($phpDocInfo->hasChanged()) {
            return $node;
        }
        return null;
    }
}
