<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PostRector\Rector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\PostRector\Collector\NodesToReplaceCollector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class NodeToReplacePostRector extends \_PhpScopere8e811afab72\Rector\PostRector\Rector\AbstractPostRector
{
    /**
     * @var NodesToReplaceCollector
     */
    private $nodesToReplaceCollector;
    public function __construct(\_PhpScopere8e811afab72\Rector\PostRector\Collector\NodesToReplaceCollector $nodesToReplaceCollector)
    {
        $this->nodesToReplaceCollector = $nodesToReplaceCollector;
    }
    public function getPriority() : int
    {
        return 1100;
    }
    public function leaveNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->nodesToReplaceCollector->getNodes() as [$nodeToFind, $replacement]) {
            if ($node === $nodeToFind) {
                return $replacement;
            }
        }
        return null;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Post Rector that replaces one nodes with another', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$string = new String_(...);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$value = 1000;
CODE_SAMPLE
)]);
    }
}
