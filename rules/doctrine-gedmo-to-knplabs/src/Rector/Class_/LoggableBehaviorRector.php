<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DoctrineGedmoToKnplabs\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\LoggableTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\VersionedTagValueNode;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/Atlantic18/DoctrineExtensions/blob/v2.4.x/doc/loggable.md
 * @see https://github.com/KnpLabs/DoctrineBehaviors/blob/4e0677379dd4adf84178f662d08454a9627781a8/docs/loggable.md
 *
 * @see \Rector\DoctrineGedmoToKnplabs\Tests\Rector\Class_\LoggableBehaviorRector\LoggableBehaviorRectorTest
 */
final class LoggableBehaviorRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator)
    {
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change Loggable from gedmo/doctrine-extensions to knplabs/doctrine-behaviors', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @Gedmo\Loggable
 */
class SomeClass
{
    /**
     * @Gedmo\Versioned
     * @ORM\Column(name="title", type="string", length=8)
     */
    private $title;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Loggable\LoggableTrait;
use Knp\DoctrineBehaviors\Contract\Entity\LoggableInterface;

/**
 * @ORM\Entity
 */
class SomeClass implements LoggableInterface
{
    use LoggableTrait;

    /**
     * @ORM\Column(name="title", type="string", length=8)
     */
    private $title;
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
        // change the node
        $classPhpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($classPhpDocInfo === null) {
            return null;
        }
        $hasTypeLoggableTagValueNode = $classPhpDocInfo->hasByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\LoggableTagValueNode::class);
        if (!$hasTypeLoggableTagValueNode) {
            return null;
        }
        $classPhpDocInfo->removeByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\LoggableTagValueNode::class);
        // remove tag from properties
        $this->removeVersionedTagFromProperties($node);
        $this->classInsertManipulator->addAsFirstTrait($node, '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Loggable\\LoggableTrait');
        $node->implements[] = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Contract\\Entity\\LoggableInterface');
        return $node;
    }
    private function removeVersionedTagFromProperties(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : void
    {
        foreach ($class->getProperties() as $property) {
            $propertyPhpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($propertyPhpDocInfo === null) {
                continue;
            }
            $hasTypeVersionedTagValueNode = $propertyPhpDocInfo->hasByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\VersionedTagValueNode::class);
            if (!$hasTypeVersionedTagValueNode) {
                continue;
            }
            $propertyPhpDocInfo->removeByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\VersionedTagValueNode::class);
        }
    }
}
