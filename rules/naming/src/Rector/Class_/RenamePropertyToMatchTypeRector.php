<?php

declare (strict_types=1);
namespace Rector\Naming\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Interface_;
use Rector\Core\Rector\AbstractRector;
use Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver;
use Rector\Naming\PropertyRenamer\MatchTypePropertyRenamer;
use Rector\Naming\ValueObjectFactory\PropertyRenameFactory;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\Class_\RenamePropertyToMatchTypeRector\RenamePropertyToMatchTypeRectorTest
 */
final class RenamePropertyToMatchTypeRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var bool
     */
    private $hasChanged = \false;
    /**
     * @var PropertyRenameFactory
     */
    private $propertyRenameFactory;
    /**
     * @var MatchTypePropertyRenamer
     */
    private $matchTypePropertyRenamer;
    /**
     * @var MatchPropertyTypeExpectedNameResolver
     */
    private $matchPropertyTypeExpectedNameResolver;
    public function __construct(\Rector\Naming\PropertyRenamer\MatchTypePropertyRenamer $matchTypePropertyRenamer, \Rector\Naming\ValueObjectFactory\PropertyRenameFactory $propertyRenameFactory, \Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver $matchPropertyTypeExpectedNameResolver)
    {
        $this->propertyRenameFactory = $propertyRenameFactory;
        $this->matchTypePropertyRenamer = $matchTypePropertyRenamer;
        $this->matchPropertyTypeExpectedNameResolver = $matchPropertyTypeExpectedNameResolver;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Rename property and method param to match its type', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var EntityManager
     */
    private $eventManager;

    public function __construct(EntityManager $eventManager)
    {
        $this->eventManager = $eventManager;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Class_::class, \PhpParser\Node\Stmt\Interface_::class];
    }
    /**
     * @param Class_|Interface_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $this->refactorClassProperties($node);
        if (!$this->hasChanged) {
            return null;
        }
        return $node;
    }
    private function refactorClassProperties(\PhpParser\Node\Stmt\ClassLike $classLike) : void
    {
        foreach ($classLike->getProperties() as $property) {
            $propertyRename = $this->propertyRenameFactory->create($property, $this->matchPropertyTypeExpectedNameResolver);
            if ($propertyRename === null) {
                continue;
            }
            $matchTypePropertyRenamerRename = $this->matchTypePropertyRenamer->rename($propertyRename);
            if ($matchTypePropertyRenamerRename !== null) {
                $this->hasChanged = \true;
            }
        }
    }
}
