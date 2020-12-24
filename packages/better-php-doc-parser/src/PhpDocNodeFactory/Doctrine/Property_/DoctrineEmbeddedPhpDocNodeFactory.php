<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Property_;

use _PhpScopere8e811afab72\Doctrine\ORM\Mapping\Embedded;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\GenericPhpDocNodeFactoryInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddedTagValueNode;
final class DoctrineEmbeddedPhpDocNodeFactory extends \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\GenericPhpDocNodeFactoryInterface
{
    /**
     * @return array<string, string>
     */
    public function getTagValueNodeClassesToAnnotationClasses() : array
    {
        return [\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddedTagValueNode::class => '_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping\\Embedded'];
    }
    public function createFromNodeAndTokens(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $annotationClass) : ?\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        /** @var Embedded|null $annotation */
        $annotation = $this->nodeAnnotationReader->readAnnotation($node, $annotationClass);
        if ($annotation === null) {
            return null;
        }
        $content = $this->resolveContentFromTokenIterator($tokenIterator);
        $items = $this->annotationItemsResolver->resolve($annotation);
        $fullyQualifiedClassName = $this->resolveFqnTargetEntity($annotation->class, $node);
        return new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddedTagValueNode($items, $content, $fullyQualifiedClassName);
    }
}
