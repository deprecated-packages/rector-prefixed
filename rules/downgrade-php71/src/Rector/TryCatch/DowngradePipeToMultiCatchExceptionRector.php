<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\TryCatch;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Catch_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\TryCatch;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp71\Tests\Rector\TryCatch\DowngradePipeToMultiCatchExceptionRector\DowngradePipeToMultiCatchExceptionRectorTest
 */
final class DowngradePipeToMultiCatchExceptionRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Downgrade single one | separated to multi catch exception', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
try {
    // Some code...
 } catch (ExceptionType1 | ExceptionType2 $exception) {
    $sameCode;
 }
CODE_SAMPLE
, <<<'CODE_SAMPLE'
try {
    // Some code...
} catch (ExceptionType1 $exception) {
    $sameCode;
} catch (ExceptionType2 $exception) {
    $sameCode;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\TryCatch::class];
    }
    /**
     * @param TryCatch $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $originalCatches = $node->catches;
        foreach ($node->catches as $key => $catch) {
            if (\count((array) $catch->types) === 1) {
                continue;
            }
            $types = $catch->types;
            $node->catches[$key]->types = [$catch->types[0]];
            foreach ($types as $keyCatchType => $catchType) {
                if ($keyCatchType === 0) {
                    continue;
                }
                $this->addNodeAfterNode(new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Catch_([$catchType], $catch->var, $catch->stmts), $node->catches[$key]);
            }
        }
        if ($this->areNodesEqual($originalCatches, $node->catches)) {
            return null;
        }
        return $node;
    }
}
