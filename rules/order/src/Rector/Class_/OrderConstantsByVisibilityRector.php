<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Order\Rector\Class_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper0a6b37af0871\Rector\Order\Rector\AbstractConstantPropertyMethodOrderRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Order\Tests\Rector\Class_\OrderConstantsByVisibilityRector\OrderConstantsByVisibilityRectorTest
 */
final class OrderConstantsByVisibilityRector extends \_PhpScoper0a6b37af0871\Rector\Order\Rector\AbstractConstantPropertyMethodOrderRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Orders constants by visibility', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    private const PRIVATE_CONST = 'private';
    protected const PROTECTED_CONST = 'protected';
    public const PUBLIC_CONST = 'public';
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public const PUBLIC_CONST = 'public';
    protected const PROTECTED_CONST = 'protected';
    private const PRIVATE_CONST = 'private';
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $currentClassConstsOrder = $this->stmtOrder->getStmtsOfTypeOrder($node, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassConst::class);
        $classConstsInDesiredOrder = $this->stmtVisibilitySorter->sortConstants($node);
        $oldToNewKeys = $this->stmtOrder->createOldToNewKeys($classConstsInDesiredOrder, $currentClassConstsOrder);
        if (!$this->hasOrderChanged($oldToNewKeys)) {
            return null;
        }
        return $this->stmtOrder->reorderClassStmtsByOldToNewKeys($node, $oldToNewKeys);
    }
}
