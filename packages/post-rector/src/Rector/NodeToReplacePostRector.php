<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PostRector\Rector;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\Rector\PostRector\Collector\NodesToReplaceCollector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class NodeToReplacePostRector extends \_PhpScoper0a6b37af0871\Rector\PostRector\Rector\AbstractPostRector
{
    /**
     * @var NodesToReplaceCollector
     */
    private $nodesToReplaceCollector;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\PostRector\Collector\NodesToReplaceCollector $nodesToReplaceCollector)
    {
        $this->nodesToReplaceCollector = $nodesToReplaceCollector;
    }
    public function getPriority() : int
    {
        return 1100;
    }
    public function leaveNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        foreach ($this->nodesToReplaceCollector->getNodes() as [$nodeToFind, $replacement]) {
            if ($node === $nodeToFind) {
                return $replacement;
            }
        }
        return null;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Post Rector that replaces one nodes with another', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$string = new String_(...);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$value = 1000;
CODE_SAMPLE
)]);
    }
}
