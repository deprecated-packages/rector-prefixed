<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\Use_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\TraitUse;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\CodingStyle\Tests\Rector\Use_\SplitGroupedUseImportsRector\SplitGroupedUseImportsRectorTest
 */
final class SplitGroupedUseImportsRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Split grouped use imports and trait statements to standalone lines', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\TraitUse::class];
    }
    /**
     * @param Use_|TraitUse $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_) {
            $this->refactorUseImport($node);
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\TraitUse) {
            $this->refactorTraitUse($node);
        }
        return null;
    }
    private function refactorUseImport(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_ $use) : void
    {
        if (\count((array) $use->uses) < 2) {
            return;
        }
        foreach ($use->uses as $singleUse) {
            $separatedUse = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_([$singleUse]);
            $this->addNodeAfterNode($separatedUse, $use);
        }
        $this->removeNode($use);
    }
    private function refactorTraitUse(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\TraitUse $traitUse) : void
    {
        if (\count((array) $traitUse->traits) < 2) {
            return;
        }
        foreach ($traitUse->traits as $singleTraitUse) {
            $separatedTraitUse = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\TraitUse([$singleTraitUse]);
            $this->addNodeAfterNode($separatedTraitUse, $traitUse);
        }
        $this->removeNode($traitUse);
    }
}
