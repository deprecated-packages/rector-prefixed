<?php

declare(strict_types=1);

namespace Rector\CodingStyle\Rector\Use_;

use PhpParser\Node;
use PhpParser\Node\Stmt\TraitUse;
use PhpParser\Node\Stmt\Use_;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\CodingStyle\Rector\Use_\SplitGroupedUseImportsRector\SplitGroupedUseImportsRectorTest
 */
final class SplitGroupedUseImportsRector extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Split grouped use imports and trait statements to standalone lines',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
use A, B;

class SomeClass
{
    use SomeTrait, AnotherTrait;
}
CODE_SAMPLE
,
                    <<<'CODE_SAMPLE'
use A;
use B;

class SomeClass
{
    use SomeTrait;
    use AnotherTrait;
}
CODE_SAMPLE
            ),
            ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Use_::class, TraitUse::class];
    }

    /**
     * @param Use_|TraitUse $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        if ($node instanceof Use_) {
            $this->refactorUseImport($node);
        }

        if ($node instanceof TraitUse) {
            $this->refactorTraitUse($node);
        }

        return null;
    }

    /**
     * @return void
     */
    private function refactorUseImport(Use_ $use)
    {
        if (count($use->uses) < 2) {
            return;
        }

        foreach ($use->uses as $singleUse) {
            $separatedUse = new Use_([$singleUse]);
            $this->addNodeAfterNode($separatedUse, $use);
        }

        $this->removeNode($use);
    }

    /**
     * @return void
     */
    private function refactorTraitUse(TraitUse $traitUse)
    {
        if (count($traitUse->traits) < 2) {
            return;
        }

        foreach ($traitUse->traits as $singleTraitUse) {
            $separatedTraitUse = new TraitUse([$singleTraitUse]);
            $this->addNodeAfterNode($separatedTraitUse, $traitUse);
        }

        $this->removeNode($traitUse);
    }
}
