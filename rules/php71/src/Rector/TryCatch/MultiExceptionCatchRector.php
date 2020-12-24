<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php71\Rector\TryCatch;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Catch_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\TryCatch;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/multiple-catch
 * @see \Rector\Php71\Tests\Rector\TryCatch\MultiExceptionCatchRector\MultiExceptionCatchRectorTest
 */
final class MultiExceptionCatchRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes multi catch of same exception to single one | separated.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\TryCatch::class];
    }
    /**
     * @param TryCatch $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::MULTI_EXCEPTION_CATCH)) {
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
    private function collectCatchKeysByContent(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\TryCatch $tryCatch) : array
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
    private function collectTypesFromCatchedByIds(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\TryCatch $tryCatch, array $catches) : array
    {
        $collectedTypes = [];
        foreach ($catches as $catch) {
            $collectedTypes = \array_merge($collectedTypes, $catch->types);
        }
        return $collectedTypes;
    }
}
