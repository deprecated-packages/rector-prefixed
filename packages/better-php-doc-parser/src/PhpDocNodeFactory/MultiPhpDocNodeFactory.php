<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocNodeFactory;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\GenericPhpDocNodeFactoryInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddableTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\InheritanceTypeTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\CustomIdGeneratorTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\LocaleTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\LoggableTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SoftDeleteableTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TranslatableTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeLeftTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeLevelTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeParentTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeRightTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeRootTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\VersionedTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectParamsTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSServiceValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPDI\PHPDIInjectTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioRouteTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertChoiceTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertEmailTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertRangeTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertTypeTagValueNode;
final class MultiPhpDocNodeFactory extends \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory implements \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\GenericPhpDocNodeFactoryInterface
{
    /**
     * @return array<string, string>
     */
    public function getTagValueNodeClassesToAnnotationClasses() : array
    {
        return [
            // tag value node class => annotation class
            // doctrine - intentionally in string, so prefixer of rector.phar doesn't prefix it
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddableTagValueNode::class => '_PhpScoper0a6b37af0871\\Doctrine\\ORM\\Mapping\\Embeddable',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class => '_PhpScoper0a6b37af0871\\Doctrine\\ORM\\Mapping\\Entity',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\InheritanceTypeTagValueNode::class => '_PhpScoper0a6b37af0871\\Doctrine\\ORM\\Mapping\\InheritanceType',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode::class => '_PhpScoper0a6b37af0871\\Doctrine\\ORM\\Mapping\\Column',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\CustomIdGeneratorTagValueNode::class => '_PhpScoper0a6b37af0871\\Doctrine\\ORM\\Mapping\\CustomIdGenerator',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode::class => '_PhpScoper0a6b37af0871\\Doctrine\\ORM\\Mapping\\Id',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode::class => '_PhpScoper0a6b37af0871\\Doctrine\\ORM\\Mapping\\GeneratedValue',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode::class => '_PhpScoper0a6b37af0871\\Doctrine\\ORM\\Mapping\\JoinColumn',
            // symfony/http-kernel
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode::class => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Routing\\Annotation\\Route',
            // symfony/validator
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertRangeTagValueNode::class => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Validator\\Constraints\\Range',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertTypeTagValueNode::class => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Validator\\Constraints\\Type',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertChoiceTagValueNode::class => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Validator\\Constraints\\Choice',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertEmailTagValueNode::class => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Validator\\Constraints\\Email',
            // gedmo
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\LocaleTagValueNode::class => '_PhpScoper0a6b37af0871\\Gedmo\\Mapping\\Annotation\\Locale',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode::class => '_PhpScoper0a6b37af0871\\Gedmo\\Mapping\\Annotation\\Blameable',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode::class => '_PhpScoper0a6b37af0871\\Gedmo\\Mapping\\Annotation\\Slug',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SoftDeleteableTagValueNode::class => '_PhpScoper0a6b37af0871\\Gedmo\\Mapping\\Annotation\\SoftDeleteable',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeRootTagValueNode::class => '_PhpScoper0a6b37af0871\\Gedmo\\Mapping\\Annotation\\TreeRoot',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeLeftTagValueNode::class => '_PhpScoper0a6b37af0871\\Gedmo\\Mapping\\Annotation\\TreeLeft',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeLevelTagValueNode::class => '_PhpScoper0a6b37af0871\\Gedmo\\Mapping\\Annotation\\TreeLevel',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeParentTagValueNode::class => '_PhpScoper0a6b37af0871\\Gedmo\\Mapping\\Annotation\\TreeParent',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeRightTagValueNode::class => '_PhpScoper0a6b37af0871\\Gedmo\\Mapping\\Annotation\\TreeRight',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\VersionedTagValueNode::class => '_PhpScoper0a6b37af0871\\Gedmo\\Mapping\\Annotation\\Versioned',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TranslatableTagValueNode::class => '_PhpScoper0a6b37af0871\\Gedmo\\Mapping\\Annotation\\Translatable',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\LoggableTagValueNode::class => '_PhpScoper0a6b37af0871\\Gedmo\\Mapping\\Annotation\\Loggable',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeTagValueNode::class => '_PhpScoper0a6b37af0871\\Gedmo\\Mapping\\Annotation\\Tree',
            // Sensio
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class => '_PhpScoper0a6b37af0871\\Sensio\\Bundle\\FrameworkExtraBundle\\Configuration\\Template',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode::class => '_PhpScoper0a6b37af0871\\Sensio\\Bundle\\FrameworkExtraBundle\\Configuration\\Method',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioRouteTagValueNode::class => '_PhpScoper0a6b37af0871\\Sensio\\Bundle\\FrameworkExtraBundle\\Configuration\\Route',
            // JMS
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectParamsTagValueNode::class => '_PhpScoper0a6b37af0871\\JMS\\DiExtraBundle\\Annotation\\InjectParams',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSServiceValueNode::class => '_PhpScoper0a6b37af0871\\JMS\\DiExtraBundle\\Annotation\\Service',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode::class => '_PhpScoper0a6b37af0871\\JMS\\Serializer\\Annotation\\Type',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPDI\PHPDIInjectTagValueNode::class => '_PhpScoper0a6b37af0871\\DI\\Annotation\\Inject',
        ];
    }
    public function createFromNodeAndTokens(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $annotationClass) : ?\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        $tagValueNodeClassesToAnnotationClasses = $this->getTagValueNodeClassesToAnnotationClasses();
        $tagValueNodeClass = \array_search($annotationClass, $tagValueNodeClassesToAnnotationClasses, \true);
        $annotation = $this->nodeAnnotationReader->readAnnotation($node, $annotationClass);
        if ($annotation === null) {
            return null;
        }
        $items = $this->annotationItemsResolver->resolve($annotation);
        $content = $this->annotationContentResolver->resolveFromTokenIterator($tokenIterator);
        return new $tagValueNodeClass($items, $content);
    }
}
