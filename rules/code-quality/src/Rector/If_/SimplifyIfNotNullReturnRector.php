<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\Rector\If_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\IfManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\If_\SimplifyIfNotNullReturnRector\SimplifyIfNotNullReturnRectorTest
 */
final class SimplifyIfNotNullReturnRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var IfManipulator
     */
    private $ifManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\IfManipulator $ifManipulator)
    {
        $this->ifManipulator = $ifManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes redundant null check to instant return', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$newNode = 'something ;
if ($newNode !== null) {
    return $newNode;
}

return null;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$newNode = 'something ;
return $newNode;
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $comparedNode = $this->ifManipulator->matchIfNotNullReturnValue($node);
        if ($comparedNode !== null) {
            $insideIfNode = $node->stmts[0];
            $nextNode = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
            if (!$nextNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_ || $nextNode->expr === null) {
                return null;
            }
            if (!$this->isNull($nextNode->expr)) {
                return null;
            }
            $this->removeNode($nextNode);
            return $insideIfNode;
        }
        $comparedNode = $this->ifManipulator->matchIfValueReturnValue($node);
        if ($comparedNode !== null) {
            $nextNode = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
            if (!$nextNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_) {
                return null;
            }
            if (!$this->areNodesEqual($comparedNode, $nextNode->expr)) {
                return null;
            }
            $this->removeNode($nextNode);
            return clone $nextNode;
        }
        return null;
    }
}
