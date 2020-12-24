<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Rector\Use_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\TraitUse;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\CodingStyle\Tests\Rector\Use_\SplitGroupedUseImportsRector\SplitGroupedUseImportsRectorTest
 */
final class SplitGroupedUseImportsRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Split grouped use imports and trait statements to standalone lines', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use A, B;

class SomeClass
{
    use SomeTrait, AnotherTrait;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use A;
use B;

class SomeClass
{
    use SomeTrait;
    use AnotherTrait;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\TraitUse::class];
    }
    /**
     * @param Use_|TraitUse $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_) {
            $this->refactorUseImport($node);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\TraitUse) {
            $this->refactorTraitUse($node);
        }
        return null;
    }
    private function refactorUseImport(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_ $use) : void
    {
        if (\count((array) $use->uses) < 2) {
            return;
        }
        foreach ($use->uses as $singleUse) {
            $separatedUse = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_([$singleUse]);
            $this->addNodeAfterNode($separatedUse, $use);
        }
        $this->removeNode($use);
    }
    private function refactorTraitUse(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\TraitUse $traitUse) : void
    {
        if (\count((array) $traitUse->traits) < 2) {
            return;
        }
        foreach ($traitUse->traits as $singleTraitUse) {
            $separatedTraitUse = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\TraitUse([$singleTraitUse]);
            $this->addNodeAfterNode($separatedTraitUse, $traitUse);
        }
        $this->removeNode($traitUse);
    }
}
