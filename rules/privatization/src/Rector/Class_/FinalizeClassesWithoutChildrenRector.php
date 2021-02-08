<?php

declare (strict_types=1);
namespace Rector\Privatization\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Rector\Core\Rector\AbstractRector;
use Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Privatization\Tests\Rector\Class_\FinalizeClassesWithoutChildrenRector\FinalizeClassesWithoutChildrenRectorTest
 */
final class FinalizeClassesWithoutChildrenRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var DoctrineDocBlockResolver
     */
    private $doctrineDocBlockResolver;
    public function __construct(\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver)
    {
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Finalize every class that has no children', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class FirstClass
{
}

class SecondClass
{
}

class ThirdClass extends SecondClass
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class FirstClass
{
}

class SecondClass
{
}

final class ThirdClass extends SecondClass
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
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node->isFinal()) {
            return null;
        }
        if ($node->isAbstract()) {
            return null;
        }
        if ($this->classNodeAnalyzer->isAnonymousClass($node)) {
            return null;
        }
        if ($this->doctrineDocBlockResolver->isDoctrineEntityClass($node)) {
            return null;
        }
        if ($this->nodeRepository->hasClassChildren($node)) {
            return null;
        }
        $this->visibilityManipulator->makeFinal($node);
        return $node;
    }
}
