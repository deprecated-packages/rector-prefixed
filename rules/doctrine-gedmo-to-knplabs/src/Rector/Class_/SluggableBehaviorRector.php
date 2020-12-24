<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DoctrineGedmoToKnplabs\Rector\Class_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/Atlantic18/DoctrineExtensions/blob/v2.4.x/doc/sluggable.md
 * @see https://github.com/KnpLabs/DoctrineBehaviors/blob/4e0677379dd4adf84178f662d08454a9627781a8/docs/sluggable.md
 *
 * @see \Rector\DoctrineGedmoToKnplabs\Tests\Rector\Class_\SluggableBehaviorRector\SluggableBehaviorRectorTest
 */
final class SluggableBehaviorRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
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
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change Sluggable from gedmo/doctrine-extensions to knplabs/doctrine-behaviors', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $slugFields = [];
        $matchedProperty = null;
        foreach ($node->getProperties() as $property) {
            $propertyPhpDocInfo = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($propertyPhpDocInfo === null) {
                continue;
            }
            /** @var SlugTagValueNode|null $slugTagValueNode */
            $slugTagValueNode = $propertyPhpDocInfo->getByType(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode::class);
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
        foreach ((array) $node->getMethods() as $classMethod) {
            if (!$this->isNames($classMethod, ['getSlug', 'setSlug'])) {
                continue;
            }
            $this->removeNode($classMethod);
        }
        $this->classInsertManipulator->addAsFirstTrait($node, '_PhpScoper0a6b37af0871\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableTrait');
        $node->implements[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified('_PhpScoper0a6b37af0871\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SluggableInterface');
        $this->addGetSluggableFieldsClassMethod($node, $slugFields);
        // change the node
        return $node;
    }
    /**
     * @param string[] $slugFields
     */
    private function addGetSluggableFieldsClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, array $slugFields) : void
    {
        $classMethod = $this->nodeFactory->createPublicMethod('getSluggableFields');
        $classMethod->returnType = new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier('array');
        $classMethod->stmts[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_($this->createArray($slugFields));
        $returnType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType());
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        $phpDocInfo->changeReturnType($returnType);
        //        $this->docBlockManipulator->addReturnTag($classMethod, new ArrayType(new MixedType(), new StringType()));
        $this->classInsertManipulator->addAsFirstMethod($class, $classMethod);
    }
}
