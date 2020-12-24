<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php71\Rector\TryCatch;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Catch_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\TryCatch;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/multiple-catch
 * @see \Rector\Php71\Tests\Rector\TryCatch\MultiExceptionCatchRector\MultiExceptionCatchRectorTest
 */
final class MultiExceptionCatchRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes multi catch of same exception to single one | separated.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
try {
    // Some code...
} catch (ExceptionType1 $exception) {
    $sameCode;
} catch (ExceptionType2 $exception) {
    $sameCode;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
try {
   // Some code...
} catch (ExceptionType1 | ExceptionType2 $exception) {
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
        if (!$this->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::MULTI_EXCEPTION_CATCH)) {
            return null;
        }
        if (\count((array) $node->catches) < 2) {
            return null;
        }
        $catchKeysByContent = $this->collectCatchKeysByContent($node);
        foreach ($catchKeysByContent as $catches) {
            // no duplicates
            if (\count($catches) < 2) {
                continue;
            }
            $collectedTypes = $this->collectTypesFromCatchedByIds($node, $catches);
            /** @var Catch_ $firstCatch */
            $firstCatch = \array_shift($catches);
            $firstCatch->types = $collectedTypes;
            foreach ($catches as $catch) {
                $this->removeNode($catch);
            }
        }
        return $node;
    }
    /**
     * @return array<string, Catch_[]>
     */
    private function collectCatchKeysByContent(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\TryCatch $tryCatch) : array
    {
        $catchKeysByContent = [];
        foreach ($tryCatch->catches as $catch) {
            $catchContent = $this->print($catch->stmts);
            $catchKeysByContent[$catchContent][] = $catch;
        }
        return $catchKeysByContent;
    }
    /**
     * @param Catch_[] $catches
     * @return Name[]
     */
    private function collectTypesFromCatchedByIds(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\TryCatch $tryCatch, array $catches) : array
    {
        $collectedTypes = [];
        foreach ($catches as $catch) {
            $collectedTypes = \array_merge($collectedTypes, $catch->types);
        }
        return $collectedTypes;
    }
}
