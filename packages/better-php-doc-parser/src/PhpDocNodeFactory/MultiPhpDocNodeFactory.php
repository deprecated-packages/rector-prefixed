<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\GenericPhpDocNodeFactoryInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddableTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\InheritanceTypeTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\CustomIdGeneratorTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\LocaleTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\LoggableTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SoftDeleteableTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TranslatableTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeLeftTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeLevelTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeParentTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeRightTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeRootTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\VersionedTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectParamsTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSServiceValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPDI\PHPDIInjectTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioRouteTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertChoiceTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertEmailTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertRangeTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertTypeTagValueNode;
final class MultiPhpDocNodeFactory extends \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\GenericPhpDocNodeFactoryInterface
{
    /**
     * @return array<string, string>
     */
    public function getTagValueNodeClassesToAnnotationClasses() : array
    {
        return [
            // tag value node class => annotation class
            // doctrine - intentionally in string, so prefixer of rector.phar doesn't prefix it
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddableTagValueNode::class => '_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping\\Embeddable',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class => '_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping\\Entity',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\InheritanceTypeTagValueNode::class => '_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping\\InheritanceType',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode::class => '_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping\\Column',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\CustomIdGeneratorTagValueNode::class => '_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping\\CustomIdGenerator',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode::class => '_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping\\Id',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode::class => '_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping\\GeneratedValue',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode::class => '_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping\\JoinColumn',
            // symfony/http-kernel
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode::class => '_PhpScopere8e811afab72\\Symfony\\Component\\Routing\\Annotation\\Route',
            // symfony/validator
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertRangeTagValueNode::class => '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Constraints\\Range',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertTypeTagValueNode::class => '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Constraints\\Type',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertChoiceTagValueNode::class => '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Constraints\\Choice',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertEmailTagValueNode::class => '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Constraints\\Email',
            // gedmo
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\LocaleTagValueNode::class => '_PhpScopere8e811afab72\\Gedmo\\Mapping\\Annotation\\Locale',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode::class => '_PhpScopere8e811afab72\\Gedmo\\Mapping\\Annotation\\Blameable',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode::class => '_PhpScopere8e811afab72\\Gedmo\\Mapping\\Annotation\\Slug',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SoftDeleteableTagValueNode::class => '_PhpScopere8e811afab72\\Gedmo\\Mapping\\Annotation\\SoftDeleteable',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeRootTagValueNode::class => '_PhpScopere8e811afab72\\Gedmo\\Mapping\\Annotation\\TreeRoot',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeLeftTagValueNode::class => '_PhpScopere8e811afab72\\Gedmo\\Mapping\\Annotation\\TreeLeft',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeLevelTagValueNode::class => '_PhpScopere8e811afab72\\Gedmo\\Mapping\\Annotation\\TreeLevel',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeParentTagValueNode::class => '_PhpScopere8e811afab72\\Gedmo\\Mapping\\Annotation\\TreeParent',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeRightTagValueNode::class => '_PhpScopere8e811afab72\\Gedmo\\Mapping\\Annotation\\TreeRight',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\VersionedTagValueNode::class => '_PhpScopere8e811afab72\\Gedmo\\Mapping\\Annotation\\Versioned',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TranslatableTagValueNode::class => '_PhpScopere8e811afab72\\Gedmo\\Mapping\\Annotation\\Translatable',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\LoggableTagValueNode::class => '_PhpScopere8e811afab72\\Gedmo\\Mapping\\Annotation\\Loggable',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeTagValueNode::class => '_PhpScopere8e811afab72\\Gedmo\\Mapping\\Annotation\\Tree',
            // Sensio
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class => '_PhpScopere8e811afab72\\Sensio\\Bundle\\FrameworkExtraBundle\\Configuration\\Template',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode::class => '_PhpScopere8e811afab72\\Sensio\\Bundle\\FrameworkExtraBundle\\Configuration\\Method',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioRouteTagValueNode::class => '_PhpScopere8e811afab72\\Sensio\\Bundle\\FrameworkExtraBundle\\Configuration\\Route',
            // JMS
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectParamsTagValueNode::class => '_PhpScopere8e811afab72\\JMS\\DiExtraBundle\\Annotation\\InjectParams',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSServiceValueNode::class => '_PhpScopere8e811afab72\\JMS\\DiExtraBundle\\Annotation\\Service',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode::class => '_PhpScopere8e811afab72\\JMS\\Serializer\\Annotation\\Type',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPDI\PHPDIInjectTagValueNode::class => '_PhpScopere8e811afab72\\DI\\Annotation\\Inject',
        ];
    }
    public function createFromNodeAndTokens(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $annotationClass) : ?\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
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
