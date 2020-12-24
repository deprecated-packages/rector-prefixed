<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/Atlantic18/DoctrineExtensions/blob/v2.4.x/doc/blameable.md
 * @see https://github.com/KnpLabs/DoctrineBehaviors/blob/2cf2585710a9f23d0c8362a7b52f45bf89dc0d3a/docs/blameable.md
 *
 * @see \Rector\DoctrineGedmoToKnplabs\Tests\Rector\Class_\BlameableBehaviorRector\BlameableBehaviorRectorTest
 */
final class BlameableBehaviorRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator)
    {
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change Blameable from gedmo/doctrine-extensions to knplabs/doctrine-behaviors', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isGedmoBlameableClass($node)) {
            return null;
        }
        $this->removeBlameablePropertiesAndMethods($node);
        $this->classInsertManipulator->addAsFirstTrait($node, '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableTrait');
        $node->implements[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified('_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface');
        return $node;
    }
    private function isGedmoBlameableClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        foreach ($class->getProperties() as $property) {
            if ($this->hasPhpDocTagValueNode($property, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode::class)) {
                return \true;
            }
        }
        return \false;
    }
    private function removeBlameablePropertiesAndMethods(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $removedPropertyNames = [];
        foreach ($class->getProperties() as $property) {
            if (!$this->hasPhpDocTagValueNode($property, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode::class)) {
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
     */
    private function removeSetterAndGetterByPropertyNames(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, array $removedPropertyNames) : void
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
