<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DowngradePhp71\Rector\TryCatch;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Catch_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\TryCatch;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp71\Tests\Rector\TryCatch\DowngradePipeToMultiCatchExceptionRector\DowngradePipeToMultiCatchExceptionRectorTest
 */
final class DowngradePipeToMultiCatchExceptionRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Downgrade single one | separated to multi catch exception', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\TryCatch::class];
    }
    /**
     * @param TryCatch $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
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
                $this->addNodeAfterNode(new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Catch_([$catchType], $catch->var, $catch->stmts), $node->catches[$key]);
            }
        }
        if ($this->areNodesEqual($originalCatches, $node->catches)) {
            return null;
        }
        return $node;
    }
}
