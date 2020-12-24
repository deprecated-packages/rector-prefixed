<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\SOLID\Rector\Class_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\SOLID\Tests\Rector\Class_\MakeUnusedClassesWithChildrenAbstractRector\MakeUnusedClassesWithChildrenAbstractRectorTest
 */
final class MakeUnusedClassesWithChildrenAbstractRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Classes that have no children nor are used, should have abstract', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass extends PossibleAbstractClass
{
}

class PossibleAbstractClass
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass extends PossibleAbstractClass
{
}

abstract class PossibleAbstractClass
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $className = $this->getName($node);
        if ($className === null) {
            return null;
        }
        $nodeRepositoryFindMethodCallsOnClass = $this->nodeRepository->findMethodCallsOnClass($className);
        // 1. is in static call?
        if ($nodeRepositoryFindMethodCallsOnClass !== []) {
            return null;
        }
        $parsedNodeCollectorFindNewsByClass = $this->parsedNodeCollector->findNewsByClass($className);
        // 2. is in new?
        if ($parsedNodeCollectorFindNewsByClass !== []) {
            return null;
        }
        $nodeRepositoryFindChildrenOfClass = $this->nodeRepository->findChildrenOfClass($className);
        // 3. does it have any children
        if ($nodeRepositoryFindChildrenOfClass === []) {
            return null;
        }
        // is abstract!
        if ($node->isAbstract()) {
            return null;
        }
        $this->makeAbstract($node);
        return $node;
    }
}
