<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PostRector\Rector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\PostRector\Collector\NodesToAddCollector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * This class collects all to-be-added expresssions (= 1 line in code)
 * and then adds new expressions to list of $nodes
 *
 * From:
 * - $this->someCall();
 *
 * To:
 * - $this->someCall();
 * - $value = this->someNewCall(); // added expression
 */
final class NodeAddingPostRector extends \_PhpScopere8e811afab72\Rector\PostRector\Rector\AbstractPostRector
{
    /**
     * @var NodesToAddCollector
     */
    private $nodesToAddCollector;
    public function __construct(\_PhpScopere8e811afab72\Rector\PostRector\Collector\NodesToAddCollector $nodesToAddCollector)
    {
        $this->nodesToAddCollector = $nodesToAddCollector;
    }
    public function getPriority() : int
    {
        return 1000;
    }
    /**
     * @return array<int|string, Node>|Node
     */
    public function leaveNode(\_PhpScopere8e811afab72\PhpParser\Node $node)
    {
        $newNodes = [$node];
        $nodesToAddAfter = $this->nodesToAddCollector->getNodesToAddAfterNode($node);
        if ($nodesToAddAfter !== []) {
            $this->nodesToAddCollector->clearNodesToAddAfter($node);
            $newNodes = \array_merge($newNodes, $nodesToAddAfter);
        }
        $nodesToAddBefore = $this->nodesToAddCollector->getNodesToAddBeforeNode($node);
        if ($nodesToAddBefore !== []) {
            $this->nodesToAddCollector->clearNodesToAddBefore($node);
            $newNodes = \array_merge($nodesToAddBefore, $newNodes);
        }
        if ($newNodes === [$node]) {
            return $node;
        }
        return $newNodes;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Post Rector that adds nodes', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$value = 1000;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$string = new String_(...);
$value = 1000;
CODE_SAMPLE
)]);
    }
}
