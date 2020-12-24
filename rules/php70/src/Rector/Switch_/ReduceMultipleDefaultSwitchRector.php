<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php70\Rector\Switch_;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Case_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Switch_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/iGDVW
 * @see https://wiki.php.net/rfc/switch.default.multiple
 * @see https://stackoverflow.com/a/44000794/1348344
 * @see https://github.com/franzliedke/wp-mpdf/commit/9dc489215fbd1adcb514810653a73dea71db8e99#diff-2f1f4a51a2dd3a73ca034a48a67a2320L1373
 * @see \Rector\Php70\Tests\Rector\Switch_\ReduceMultipleDefaultSwitchRector\ReduceMultipleDefaultSwitchRectorTest
 */
final class ReduceMultipleDefaultSwitchRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove first default switch, that is ignored', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
switch ($expr) {
    default:
         echo "Hello World";

    default:
         echo "Goodbye Moon!";
         break;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
switch ($expr) {
    default:
         echo "Goodbye Moon!";
         break;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Switch_::class];
    }
    /**
     * @param Switch_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $defaultCases = [];
        foreach ($node->cases as $case) {
            if ($case->cond !== null) {
                continue;
            }
            $defaultCases[] = $case;
        }
        if (\count($defaultCases) < 2) {
            return null;
        }
        $this->removeExtraDefaultCases($defaultCases);
        return $node;
    }
    /**
     * @param Case_[] $defaultCases
     */
    private function removeExtraDefaultCases(array $defaultCases) : void
    {
        // keep only last
        \array_pop($defaultCases);
        foreach ($defaultCases as $defaultCase) {
            $this->keepStatementsToParentCase($defaultCase);
            $this->removeNode($defaultCase);
        }
    }
    private function keepStatementsToParentCase(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Case_ $case) : void
    {
        $previousNode = $case->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if (!$previousNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Case_) {
            return;
        }
        if ($previousNode->stmts === []) {
            $previousNode->stmts = $case->stmts;
            $case->stmts = [];
        }
    }
}
