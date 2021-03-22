<?php

declare (strict_types=1);
namespace Rector\Doctrine\PhpDoc\NodeFactory;

use Doctrine\ORM\Mapping\Annotation;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use Rector\BetterPhpDocParser\Contract\MultiPhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory;
use Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter;
use Rector\BetterPhpDocParser\Printer\TagValueNodePrinter;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Class_\EmbeddableTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Class_\EmbeddedTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Class_\EntityTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Class_\InheritanceTypeTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Gedmo\BlameableTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Gedmo\LocaleTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Gedmo\LoggableTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Gedmo\SlugTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Gedmo\SoftDeleteableTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Gedmo\TranslatableTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Gedmo\TreeLeftTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Gedmo\TreeLevelTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Gedmo\TreeParentTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Gedmo\TreeRightTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Gedmo\TreeRootTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Gedmo\TreeTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Gedmo\VersionedTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Property_\ColumnTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Property_\CustomIdGeneratorTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Property_\GeneratedValueTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Property_\IdTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Property_\JoinColumnTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Property_\ManyToManyTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Property_\ManyToOneTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Property_\OneToManyTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Property_\OneToOneTagValueNode;
final class MultiPhpDocNodeFactory extends \Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory implements \Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface, \Rector\BetterPhpDocParser\Contract\MultiPhpDocNodeFactoryInterface
{
    /**
     * @var ArrayPartPhpDocTagPrinter
     */
    private $arrayPartPhpDocTagPrinter;
    /**
     * @var TagValueNodePrinter
     */
    private $tagValueNodePrinter;
    public function __construct(\Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter $arrayPartPhpDocTagPrinter, \Rector\BetterPhpDocParser\Printer\TagValueNodePrinter $tagValueNodePrinter)
    {
        $this->arrayPartPhpDocTagPrinter = $arrayPartPhpDocTagPrinter;
        $this->tagValueNodePrinter = $tagValueNodePrinter;
    }
    /**
     * @return array<class-string<AbstractTagValueNode>, class-string<Annotation>>
     */
    public function getTagValueNodeClassesToAnnotationClasses() : array
    {
        return [
            // tag value node class => annotation class
            // Doctrine - intentionally in string, so prefixer wont miss it
            \Rector\Doctrine\PhpDoc\Node\Class_\EmbeddableTagValueNode::class => 'Doctrine\\ORM\\Mapping\\Embeddable',
            \Rector\Doctrine\PhpDoc\Node\Class_\EntityTagValueNode::class => 'Doctrine\\ORM\\Mapping\\Entity',
            \Rector\Doctrine\PhpDoc\Node\Class_\InheritanceTypeTagValueNode::class => 'Doctrine\\ORM\\Mapping\\InheritanceType',
            \Rector\Doctrine\PhpDoc\Node\Property_\ColumnTagValueNode::class => 'Doctrine\\ORM\\Mapping\\Column',
            \Rector\Doctrine\PhpDoc\Node\Property_\CustomIdGeneratorTagValueNode::class => 'Doctrine\\ORM\\Mapping\\CustomIdGenerator',
            \Rector\Doctrine\PhpDoc\Node\Property_\IdTagValueNode::class => 'Doctrine\\ORM\\Mapping\\Id',
            \Rector\Doctrine\PhpDoc\Node\Property_\GeneratedValueTagValueNode::class => 'Doctrine\\ORM\\Mapping\\GeneratedValue',
            \Rector\Doctrine\PhpDoc\Node\Property_\JoinColumnTagValueNode::class => 'Doctrine\\ORM\\Mapping\\JoinColumn',
            // Gedmo
            \Rector\Doctrine\PhpDoc\Node\Gedmo\LocaleTagValueNode::class => 'Gedmo\\Mapping\\Annotation\\Locale',
            \Rector\Doctrine\PhpDoc\Node\Gedmo\BlameableTagValueNode::class => 'Gedmo\\Mapping\\Annotation\\Blameable',
            \Rector\Doctrine\PhpDoc\Node\Gedmo\SlugTagValueNode::class => 'Gedmo\\Mapping\\Annotation\\Slug',
            \Rector\Doctrine\PhpDoc\Node\Gedmo\SoftDeleteableTagValueNode::class => 'Gedmo\\Mapping\\Annotation\\SoftDeleteable',
            \Rector\Doctrine\PhpDoc\Node\Gedmo\TreeRootTagValueNode::class => 'Gedmo\\Mapping\\Annotation\\TreeRoot',
            \Rector\Doctrine\PhpDoc\Node\Gedmo\TreeLeftTagValueNode::class => 'Gedmo\\Mapping\\Annotation\\TreeLeft',
            \Rector\Doctrine\PhpDoc\Node\Gedmo\TreeLevelTagValueNode::class => 'Gedmo\\Mapping\\Annotation\\TreeLevel',
            \Rector\Doctrine\PhpDoc\Node\Gedmo\TreeParentTagValueNode::class => 'Gedmo\\Mapping\\Annotation\\TreeParent',
            \Rector\Doctrine\PhpDoc\Node\Gedmo\TreeRightTagValueNode::class => 'Gedmo\\Mapping\\Annotation\\TreeRight',
            \Rector\Doctrine\PhpDoc\Node\Gedmo\VersionedTagValueNode::class => 'Gedmo\\Mapping\\Annotation\\Versioned',
            \Rector\Doctrine\PhpDoc\Node\Gedmo\TranslatableTagValueNode::class => 'Gedmo\\Mapping\\Annotation\\Translatable',
            \Rector\Doctrine\PhpDoc\Node\Gedmo\LoggableTagValueNode::class => 'Gedmo\\Mapping\\Annotation\\Loggable',
            \Rector\Doctrine\PhpDoc\Node\Gedmo\TreeTagValueNode::class => 'Gedmo\\Mapping\\Annotation\\Tree',
            // Doctrine
            \Rector\Doctrine\PhpDoc\Node\Property_\OneToOneTagValueNode::class => 'Doctrine\\ORM\\Mapping\\OneToOne',
            \Rector\Doctrine\PhpDoc\Node\Property_\OneToManyTagValueNode::class => 'Doctrine\\ORM\\Mapping\\OneToMany',
            \Rector\Doctrine\PhpDoc\Node\Property_\ManyToManyTagValueNode::class => 'Doctrine\\ORM\\Mapping\\ManyToMany',
            \Rector\Doctrine\PhpDoc\Node\Property_\ManyToOneTagValueNode::class => 'Doctrine\\ORM\\Mapping\\ManyToOne',
            // @todo cover with reflection / services to avoid forgetting registering it?
            \Rector\Doctrine\PhpDoc\Node\Class_\EmbeddedTagValueNode::class => 'Doctrine\\ORM\\Mapping\\Embedded',
        ];
    }
    public function createFromNodeAndTokens(\PhpParser\Node $node, \PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $annotationClass) : ?\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        $annotation = $this->nodeAnnotationReader->readAnnotation($node, $annotationClass);
        if ($annotation === null) {
            return null;
        }
        $tagValueNodeClassesToAnnotationClasses = $this->getTagValueNodeClassesToAnnotationClasses();
        $tagValueNodeClass = \array_search($annotationClass, $tagValueNodeClassesToAnnotationClasses, \true);
        if ($tagValueNodeClass === \false) {
            return null;
        }
        $items = $this->annotationItemsResolver->resolve($annotation);
        $content = $this->annotationContentResolver->resolveFromTokenIterator($tokenIterator);
        if (\is_a($tagValueNodeClass, \Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class, \true)) {
            /** @var ManyToOne|OneToMany|ManyToMany|OneToOne|Embedded $annotation */
            $fullyQualifiedTargetEntity = $this->resolveEntityClass($annotation, $node);
            return new $tagValueNodeClass($this->arrayPartPhpDocTagPrinter, $this->tagValueNodePrinter, $items, $content, $fullyQualifiedTargetEntity);
        }
        return new $tagValueNodeClass($this->arrayPartPhpDocTagPrinter, $this->tagValueNodePrinter, $items, $content);
    }
    /**
     * @param ManyToOne|OneToMany|ManyToMany|OneToOne|Embedded $annotation
     */
    private function resolveEntityClass($annotation, \PhpParser\Node $node) : string
    {
        if ($annotation instanceof \Doctrine\ORM\Mapping\Embedded) {
            return $this->resolveFqnTargetEntity($annotation->class, $node);
        }
        return $this->resolveFqnTargetEntity($annotation->targetEntity, $node);
    }
}
