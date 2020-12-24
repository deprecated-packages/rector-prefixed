<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\Use_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\TraitUse;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\CodingStyle\Tests\Rector\Use_\SplitGroupedUseImportsRector\SplitGroupedUseImportsRectorTest
 */
final class SplitGroupedUseImportsRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Split grouped use imports and trait statements to standalone lines', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\TraitUse::class];
    }
    /**
     * @param Use_|TraitUse $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_) {
            $this->refactorUseImport($node);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\TraitUse) {
            $this->refactorTraitUse($node);
        }
        return null;
    }
    private function refactorUseImport(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_ $use) : void
    {
        if (\count((array) $use->uses) < 2) {
            return;
        }
        foreach ($use->uses as $singleUse) {
            $separatedUse = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_([$singleUse]);
            $this->addNodeAfterNode($separatedUse, $use);
        }
        $this->removeNode($use);
    }
    private function refactorTraitUse(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\TraitUse $traitUse) : void
    {
        if (\count((array) $traitUse->traits) < 2) {
            return;
        }
        foreach ($traitUse->traits as $singleTraitUse) {
            $separatedTraitUse = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\TraitUse([$singleTraitUse]);
            $this->addNodeAfterNode($separatedTraitUse, $traitUse);
        }
        $this->removeNode($traitUse);
    }
}
