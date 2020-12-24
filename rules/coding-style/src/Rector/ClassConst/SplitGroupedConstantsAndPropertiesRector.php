<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\ClassConst;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Const_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\PropertyProperty;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\ClassConst\SplitGroupedConstantsAndPropertiesRector\SplitGroupedConstantsAndPropertiesRectorTest
 */
final class SplitGroupedConstantsAndPropertiesRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Separate constant and properties to own lines', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    const HI = true, AHOJ = 'true';

    /**
     * @var string
     */
    public $isIt, $isIsThough;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    const HI = true;
    const AHOJ = 'true';

    /**
     * @var string
     */
    public $isIt;

    /**
     * @var string
     */
    public $isIsThough;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassConst::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param ClassConst|Property $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassConst) {
            if (\count((array) $node->consts) < 2) {
                return null;
            }
            /** @var Const_[] $allConsts */
            $allConsts = $node->consts;
            /** @var Const_ $firstConst */
            $firstConst = \array_shift($allConsts);
            $node->consts = [$firstConst];
            $nextClassConsts = $this->createNextClassConsts($allConsts, $node);
            $this->addNodesAfterNode($nextClassConsts, $node);
            return $node;
        }
        if (\count((array) $node->props) < 2) {
            return null;
        }
        $allProperties = $node->props;
        /** @var PropertyProperty $firstPropertyProperty */
        $firstPropertyProperty = \array_shift($allProperties);
        $node->props = [$firstPropertyProperty];
        foreach ($allProperties as $anotherProperty) {
            $nextProperty = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property($node->flags, [$anotherProperty], $node->getAttributes());
            $this->addNodeAfterNode($nextProperty, $node);
        }
        return $node;
    }
    /**
     * @param Const_[] $consts
     * @return ClassConst[]
     */
    private function createNextClassConsts(array $consts, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassConst $classConst) : array
    {
        $decoratedConsts = [];
        foreach ($consts as $const) {
            $decoratedConsts[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassConst([$const], $classConst->flags, $classConst->getAttributes());
        }
        return $decoratedConsts;
    }
}
