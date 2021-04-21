<?php

declare(strict_types=1);

namespace Rector\PostRector\Rector;

use PhpParser\Node;
use Rector\PostRector\Collector\NodesToReplaceCollector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class NodeToReplacePostRector extends AbstractPostRector
{
    /**
     * @var NodesToReplaceCollector
     */
    private $nodesToReplaceCollector;

    public function __construct(NodesToReplaceCollector $nodesToReplaceCollector)
    {
        $this->nodesToReplaceCollector = $nodesToReplaceCollector;
    }

    public function getPriority(): int
    {
        return 1100;
    }

    /**
     * @return \PhpParser\Node|null
     */
    public function leaveNode(Node $node)
    {
        foreach ($this->nodesToReplaceCollector->getNodes() as list($nodeToFind, $replacement)) {
            if ($node === $nodeToFind) {
                return $replacement;
            }
        }

        return null;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Replaces nodes on weird positions', [
            new CodeSample(
                    <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($value)
    {
        return 1;
    }
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($value)
    {
        return $value;
    }
}
CODE_SAMPLE
            ), ]
        );
    }
}
