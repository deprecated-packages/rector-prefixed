<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DoctrineGedmoToKnplabs\Rector\Class_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SoftDeleteableTagValueNode;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/Atlantic18/DoctrineExtensions/blob/v2.4.x/doc/softdeleteable.md
 * @see https://github.com/KnpLabs/DoctrineBehaviors/blob/4e0677379dd4adf84178f662d08454a9627781a8/docs/soft-deletable.md
 *
 * @see \Rector\DoctrineGedmoToKnplabs\Tests\Rector\Class_\SoftDeletableBehaviorRector\SoftDeletableBehaviorRectorTest
 */
final class SoftDeletableBehaviorRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator)
    {
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change SoftDeletable from gedmo/doctrine-extensions to knplabs/doctrine-behaviors', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $classPhpDocInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($classPhpDocInfo === null) {
            return null;
        }
        $hasTypeSoftDeleteableTagValueNode = $classPhpDocInfo->hasByType(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SoftDeleteableTagValueNode::class);
        if (!$hasTypeSoftDeleteableTagValueNode) {
            return null;
        }
        /** @var SoftDeleteableTagValueNode $softDeleteableTagValueNode */
        $softDeleteableTagValueNode = $classPhpDocInfo->getByType(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SoftDeleteableTagValueNode::class);
        $fieldName = $softDeleteableTagValueNode->getFieldName();
        $this->removePropertyAndClassMethods($node, $fieldName);
        $this->classInsertManipulator->addAsFirstTrait($node, '_PhpScoper0a6b37af0871\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableTrait');
        $node->implements[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified('_PhpScoper0a6b37af0871\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface');
        $classPhpDocInfo->removeByType(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SoftDeleteableTagValueNode::class);
        return $node;
    }
    private function removePropertyAndClassMethods(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, string $fieldName) : void
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
