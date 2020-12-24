<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Property_;

use _PhpScopere8e811afab72\Doctrine\ORM\Mapping\ManyToMany;
use _PhpScopere8e811afab72\Doctrine\ORM\Mapping\ManyToOne;
use _PhpScopere8e811afab72\Doctrine\ORM\Mapping\OneToMany;
use _PhpScopere8e811afab72\Doctrine\ORM\Mapping\OneToOne;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\GenericPhpDocNodeFactoryInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ManyToManyTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ManyToOneTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToOneTagValueNode;
final class DoctrineTargetEntityPhpDocNodeFactory extends \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\GenericPhpDocNodeFactoryInterface
{
    /**
     * @return array<string, string>
     */
    public function getTagValueNodeClassesToAnnotationClasses() : array
    {
        return [\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToOneTagValueNode::class => '_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping\\OneToOne', \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode::class => '_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping\\OneToMany', \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ManyToManyTagValueNode::class => '_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping\\ManyToMany', \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ManyToOneTagValueNode::class => '_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping\\ManyToOne'];
    }
    public function createFromNodeAndTokens(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $annotationClass) : ?\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        /** @var OneToOne|OneToMany|ManyToMany|ManyToOne|null $annotation */
        $annotation = $this->nodeAnnotationReader->readAnnotation($node, $annotationClass);
        if ($annotation === null) {
            return null;
        }
        $tagValueNodeClassesToAnnotationClasses = $this->getTagValueNodeClassesToAnnotationClasses();
        $tagValueNodeClass = \array_search($annotationClass, $tagValueNodeClassesToAnnotationClasses, \true);
        $content = $this->resolveContentFromTokenIterator($tokenIterator);
        $items = $this->annotationItemsResolver->resolve($annotation);
        $fullyQualifiedTargetEntity = $this->resolveFqnTargetEntity($annotation->targetEntity, $node);
        return new $tagValueNodeClass($items, $content, $fullyQualifiedTargetEntity);
    }
}
