<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Class_;

use _PhpScopere8e811afab72\Doctrine\Common\Collections\ArrayCollection;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\ToManyTagNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/best-practices.html#initialize-collections-in-the-constructor
 *
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\Class_\InitializeDefaultEntityCollectionRector\InitializeDefaultEntityCollectionRectorTest
 */
final class InitializeDefaultEntityCollectionRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassDependencyManipulator
     */
    private $classDependencyManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator $classDependencyManipulator)
    {
        $this->classDependencyManipulator = $classDependencyManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Initialize collection property in Entity constructor', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SomeClass
{
    /**
     * @ORM\OneToMany(targetEntity="MarketingEvent")
     */
    private $marketingEvents = [];
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SomeClass
{
    /**
     * @ORM\OneToMany(targetEntity="MarketingEvent")
     */
    private $marketingEvents = [];

    public function __construct()
    {
        $this->marketingEvents = new ArrayCollection();
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->hasPhpDocTagValueNode($node, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class)) {
            return null;
        }
        $toManyPropertyNames = $this->resolveToManyPropertyNames($node);
        if ($toManyPropertyNames === []) {
            return null;
        }
        $assigns = $this->createAssignsOfArrayCollectionsForPropertyNames($toManyPropertyNames);
        $this->classDependencyManipulator->addStmtsToConstructorIfNotThereYet($node, $assigns);
        return $node;
    }
    /**
     * @return string[]
     */
    private function resolveToManyPropertyNames(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $collectionPropertyNames = [];
        foreach ($class->getProperties() as $property) {
            if (\count((array) $property->props) !== 1) {
                continue;
            }
            if (!$this->hasPhpDocTagValueNode($property, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\ToManyTagNodeInterface::class)) {
                continue;
            }
            /** @var string $propertyName */
            $propertyName = $this->getName($property);
            $collectionPropertyNames[] = $propertyName;
        }
        return $collectionPropertyNames;
    }
    /**
     * @param string[] $propertyNames
     * @return Expression[]
     */
    private function createAssignsOfArrayCollectionsForPropertyNames(array $propertyNames) : array
    {
        $assigns = [];
        foreach ($propertyNames as $propertyName) {
            $assigns[] = $this->createPropertyArrayCollectionAssign($propertyName);
        }
        return $assigns;
    }
    private function createPropertyArrayCollectionAssign(string $toManyPropertyName) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $propertyFetch = $this->createPropertyFetch('this', $toManyPropertyName);
        $new = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified(\_PhpScopere8e811afab72\Doctrine\Common\Collections\ArrayCollection::class));
        $assign = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($propertyFetch, $new);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($assign);
    }
}
