<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Rector\Expression;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Nop;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\Expression\RemoveDeadStmtRector\RemoveDeadStmtRectorTest
 */
final class RemoveDeadStmtRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes dead code statements', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$value = 5;
$value;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$value = 5;
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression::class];
    }
    /**
     * @param Expression $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $livingCode = $this->livingCodeManipulator->keepLivingCodeFromExpr($node->expr);
        if ($livingCode === []) {
            return $this->removeNodeAndKeepComments($node);
        }
        $firstExpr = \array_shift($livingCode);
        $node->expr = $firstExpr;
        foreach ($livingCode as $expr) {
            $newNode = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($expr);
            $this->addNodeAfterNode($newNode, $node);
        }
        return null;
    }
    private function removeNodeAndKeepComments(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression $expression) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $expression->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($expression->getComments() !== []) {
            $nop = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Nop();
            $nop->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $phpDocInfo);
            $this->phpDocInfoFactory->createFromNode($nop);
            return $nop;
        }
        $this->removeNode($expression);
        return null;
    }
}
