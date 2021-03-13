<?php

declare (strict_types=1);
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
final class SplitGroupedUseImportsRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Split grouped use imports and trait statements to standalone lines', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Use_::class, \PhpParser\Node\Stmt\TraitUse::class];
    }
    /**
     * @param Use_|TraitUse $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Stmt\Use_) {
            $this->refactorUseImport($node);
        }
        if ($node instanceof \PhpParser\Node\Stmt\TraitUse) {
            $this->refactorTraitUse($node);
        }
        return null;
    }
    private function refactorUseImport(\PhpParser\Node\Stmt\Use_ $use) : void
    {
        if (\count($use->uses) < 2) {
            return;
        }
        foreach ($use->uses as $singleUse) {
            $separatedUse = new \PhpParser\Node\Stmt\Use_([$singleUse]);
            $this->addNodeAfterNode($separatedUse, $use);
        }
        $this->removeNode($use);
    }
    private function refactorTraitUse(\PhpParser\Node\Stmt\TraitUse $traitUse) : void
    {
        if (\count($traitUse->traits) < 2) {
            return;
        }
        foreach ($traitUse->traits as $singleTraitUse) {
            $separatedTraitUse = new \PhpParser\Node\Stmt\TraitUse([$singleTraitUse]);
            $this->addNodeAfterNode($separatedTraitUse, $traitUse);
        }
        $this->removeNode($traitUse);
    }
}
