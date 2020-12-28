<?php

declare (strict_types=1);
namespace Rector\DoctrineGedmoToKnplabs\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SoftDeleteableTagValueNode;
use Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/Atlantic18/DoctrineExtensions/blob/v2.4.x/doc/softdeleteable.md
 * @see https://github.com/KnpLabs/DoctrineBehaviors/blob/4e0677379dd4adf84178f662d08454a9627781a8/docs/soft-deletable.md
 *
 * @see \Rector\DoctrineGedmoToKnplabs\Tests\Rector\Class_\SoftDeletableBehaviorRector\SoftDeletableBehaviorRectorTest
 */
final class SoftDeletableBehaviorRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    public function __construct(\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator)
    {
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change SoftDeletable from gedmo/doctrine-extensions to knplabs/doctrine-behaviors', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class SomeClass
{
    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Knp\DoctrineBehaviors\Contract\Entity\SoftDeletableInterface;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletableTrait;

class SomeClass implements SoftDeletableInterface
{
    use SoftDeletableTrait;
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
        $classPhpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($classPhpDocInfo === null) {
            return null;
        }
        $hasTypeSoftDeleteableTagValueNode = $classPhpDocInfo->hasByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SoftDeleteableTagValueNode::class);
        if (!$hasTypeSoftDeleteableTagValueNode) {
            return null;
        }
        /** @var SoftDeleteableTagValueNode $softDeleteableTagValueNode */
        $softDeleteableTagValueNode = $classPhpDocInfo->getByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SoftDeleteableTagValueNode::class);
        $fieldName = $softDeleteableTagValueNode->getFieldName();
        $this->removePropertyAndClassMethods($node, $fieldName);
        $this->classInsertManipulator->addAsFirstTrait($node, 'RectorPrefix20201228\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableTrait');
        $node->implements[] = new \PhpParser\Node\Name\FullyQualified('RectorPrefix20201228\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface');
        $classPhpDocInfo->removeByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SoftDeleteableTagValueNode::class);
        return $node;
    }
    private function removePropertyAndClassMethods(\PhpParser\Node\Stmt\Class_ $class, string $fieldName) : void
    {
        // remove property
        foreach ($class->getProperties() as $property) {
            if (!$this->isName($property, $fieldName)) {
                continue;
            }
            $this->removeNode($property);
        }
        // remove methods
        $setMethodName = 'set' . \ucfirst($fieldName);
        $getMethodName = 'get' . \ucfirst($fieldName);
        foreach ($class->getMethods() as $classMethod) {
            if (!$this->isNames($classMethod, [$setMethodName, $getMethodName])) {
                continue;
            }
            $this->removeNode($classMethod);
        }
    }
}
