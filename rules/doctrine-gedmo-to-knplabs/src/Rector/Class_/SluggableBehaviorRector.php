<?php

declare (strict_types=1);
namespace Rector\DoctrineGedmoToKnplabs\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use PHPStan\Type\StringType;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode;
use Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/Atlantic18/DoctrineExtensions/blob/v2.4.x/doc/sluggable.md
 * @see https://github.com/KnpLabs/DoctrineBehaviors/blob/4e0677379dd4adf84178f662d08454a9627781a8/docs/sluggable.md
 *
 * @see \Rector\DoctrineGedmoToKnplabs\Tests\Rector\Class_\SluggableBehaviorRector\SluggableBehaviorRectorTest
 */
final class SluggableBehaviorRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    public function __construct(\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator)
    {
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change Sluggable from gedmo/doctrine-extensions to knplabs/doctrine-behaviors', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Gedmo\Mapping\Annotation as Gedmo;

class SomeClass
{
    /**
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model\Sluggable\SluggableTrait;
use Knp\DoctrineBehaviors\Contract\Entity\SluggableInterface;

class SomeClass implements SluggableInterface
{
    use SluggableTrait;

    /**
     * @return string[]
     */
    public function getSluggableFields(): array
    {
        return ['name'];
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
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $slugFields = [];
        $matchedProperty = null;
        foreach ($node->getProperties() as $property) {
            $propertyPhpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($propertyPhpDocInfo === null) {
                continue;
            }
            /** @var SlugTagValueNode|null $slugTagValueNode */
            $slugTagValueNode = $propertyPhpDocInfo->getByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode::class);
            if ($slugTagValueNode === null) {
                continue;
            }
            $slugFields = $slugTagValueNode->getFields();
            $this->removeNode($property);
            $matchedProperty = $property;
        }
        if ($matchedProperty === null) {
            return null;
        }
        // remove property setter/getter
        foreach ($node->getMethods() as $classMethod) {
            if (!$this->isNames($classMethod, ['getSlug', 'setSlug'])) {
                continue;
            }
            $this->removeNode($classMethod);
        }
        $this->classInsertManipulator->addAsFirstTrait($node, '_PhpScoper5edc98a7cce2\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableTrait');
        $node->implements[] = new \PhpParser\Node\Name\FullyQualified('_PhpScoper5edc98a7cce2\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SluggableInterface');
        $this->addGetSluggableFieldsClassMethod($node, $slugFields);
        // change the node
        return $node;
    }
    /**
     * @param string[] $slugFields
     */
    private function addGetSluggableFieldsClassMethod(\PhpParser\Node\Stmt\Class_ $class, array $slugFields) : void
    {
        $classMethod = $this->nodeFactory->createPublicMethod('getSluggableFields');
        $classMethod->returnType = new \PhpParser\Node\Identifier('array');
        $classMethod->stmts[] = new \PhpParser\Node\Stmt\Return_($this->createArray($slugFields));
        $returnType = new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType());
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        $phpDocInfo->changeReturnType($returnType);
        //        $this->docBlockManipulator->addReturnTag($classMethod, new ArrayType(new MixedType(), new StringType()));
        $this->classInsertManipulator->addAsFirstMethod($class, $classMethod);
    }
}
