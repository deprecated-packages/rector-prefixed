<?php

declare (strict_types=1);
namespace Rector\DoctrineGedmoToKnplabs\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode;
use Rector\Core\NodeManipulator\ClassInsertManipulator;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/Atlantic18/DoctrineExtensions/blob/v2.4.x/doc/blameable.md
 * @see https://github.com/KnpLabs/DoctrineBehaviors/blob/2cf2585710a9f23d0c8362a7b52f45bf89dc0d3a/docs/blameable.md
 *
 * @see \Rector\Tests\DoctrineGedmoToKnplabs\Rector\Class_\BlameableBehaviorRector\BlameableBehaviorRectorTest
 */
final class BlameableBehaviorRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    /**
     * @param \Rector\Core\NodeManipulator\ClassInsertManipulator $classInsertManipulator
     */
    public function __construct($classInsertManipulator)
    {
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change Blameable from gedmo/doctrine-extensions to knplabs/doctrine-behaviors', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SomeClass
{
    /**
     * @Gedmo\Blameable(on="create")
     */
    private $createdBy;

    /**
     * @Gedmo\Blameable(on="update")
     */
    private $updatedBy;

    /**
     * @Gedmo\Blameable(on="change", field={"title", "body"})
     */
    private $contentChangedBy;

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    public function getContentChangedBy()
    {
        return $this->contentChangedBy;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\BlameableInterface;
use Knp\DoctrineBehaviors\Model\Blameable\BlameableTrait;

/**
 * @ORM\Entity
 */
class SomeClass implements BlameableInterface
{
    use BlameableTrait;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        if (!$this->isGedmoBlameableClass($node)) {
            return null;
        }
        $this->removeBlameablePropertiesAndMethods($node);
        $this->classInsertManipulator->addAsFirstTrait($node, 'Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableTrait');
        $node->implements[] = new \PhpParser\Node\Name\FullyQualified('Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface');
        return $node;
    }
    /**
     * @param \PhpParser\Node\Stmt\Class_ $class
     */
    private function isGedmoBlameableClass($class) : bool
    {
        foreach ($class->getProperties() as $property) {
            $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
            if ($phpDocInfo->hasByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode::class)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param \PhpParser\Node\Stmt\Class_ $class
     */
    private function removeBlameablePropertiesAndMethods($class) : void
    {
        $removedPropertyNames = [];
        foreach ($class->getProperties() as $property) {
            $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
            if (!$phpDocInfo->hasByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode::class)) {
                continue;
            }
            /** @var string $propertyName */
            $propertyName = $this->getName($property);
            $removedPropertyNames[] = $propertyName;
            $this->removeNode($property);
        }
        $this->removeSetterAndGetterByPropertyNames($class, $removedPropertyNames);
    }
    /**
     * @param string[] $removedPropertyNames
     * @param \PhpParser\Node\Stmt\Class_ $class
     */
    private function removeSetterAndGetterByPropertyNames($class, $removedPropertyNames) : void
    {
        foreach ($class->getMethods() as $classMethod) {
            foreach ($removedPropertyNames as $removedPropertyName) {
                // remove methods
                $setMethodName = 'set' . \ucfirst($removedPropertyName);
                $getMethodName = 'get' . \ucfirst($removedPropertyName);
                if ($this->isNames($classMethod, [$setMethodName, $getMethodName])) {
                    continue;
                }
                $this->removeNode($classMethod);
            }
        }
    }
}
