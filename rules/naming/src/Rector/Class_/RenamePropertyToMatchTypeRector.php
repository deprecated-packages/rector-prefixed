<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver;
use _PhpScopere8e811afab72\Rector\Naming\PropertyRenamer\MatchTypePropertyRenamer;
use _PhpScopere8e811afab72\Rector\Naming\ValueObjectFactory\PropertyRenameFactory;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\Class_\RenamePropertyToMatchTypeRector\RenamePropertyToMatchTypeRectorTest
 */
final class RenamePropertyToMatchTypeRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Naming\PropertyRenamer\MatchTypePropertyRenamer $matchTypePropertyRenamer, \_PhpScopere8e811afab72\Rector\Naming\ValueObjectFactory\PropertyRenameFactory $propertyRenameFactory, \_PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver $matchPropertyTypeExpectedNameResolver)
    {
        $this->propertyRenameFactory = $propertyRenameFactory;
        $this->matchTypePropertyRenamer = $matchTypePropertyRenamer;
        $this->matchPropertyTypeExpectedNameResolver = $matchPropertyTypeExpectedNameResolver;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Rename property and method param to match its type', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_::class];
    }
    /**
     * @param Class_|Interface_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $this->refactorClassProperties($node);
        if (!$this->hasChanged) {
            return null;
        }
        return $node;
    }
    private function refactorClassProperties(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : void
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
