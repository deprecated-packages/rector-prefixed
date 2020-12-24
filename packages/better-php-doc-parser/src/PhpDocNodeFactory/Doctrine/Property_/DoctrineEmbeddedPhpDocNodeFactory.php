<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Property_;

use _PhpScoper0a6b37af0871\Doctrine\ORM\Mapping\Embedded;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\GenericPhpDocNodeFactoryInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddedTagValueNode;
final class DoctrineEmbeddedPhpDocNodeFactory extends \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory implements \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\GenericPhpDocNodeFactoryInterface
{
    /**
     * @return array<string, string>
     */
    public function getTagValueNodeClassesToAnnotationClasses() : array
    {
        return [\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddedTagValueNode::class => '_PhpScoper0a6b37af0871\\Doctrine\\ORM\\Mapping\\Embedded'];
    }
    public function createFromNodeAndTokens(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $annotationClass) : ?\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        /** @var Embedded|null $annotation */
        $annotation = $this->nodeAnnotationReader->readAnnotation($node, $annotationClass);
        if ($annotation === null) {
            return null;
        }
        $content = $this->resolveContentFromTokenIterator($tokenIterator);
        $items = $this->annotationItemsResolver->resolve($annotation);
        $fullyQualifiedClassName = $this->resolveFqnTargetEntity($annotation->class, $node);
        return new \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddedTagValueNode($items, $content, $fullyQualifiedClassName);
    }
}
