<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\PhpDoc;

use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueParameterNode;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareMethodTagValueParameterNode;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareMethodTagValueParameterNodeFactory implements \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface, \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface
{
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    public function getOriginalNodeClass() : string
    {
        return \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueParameterNode::class;
    }
    public function isMatch(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        return \is_a($node, \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueParameterNode::class, \true);
    }
    /**
     * @param MethodTagValueParameterNode $node
     */
    public function create(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        if ($node->type !== null) {
            $node->type = $this->attributeAwareNodeFactory->createFromNode($node->type, $docContent);
        }
        return new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareMethodTagValueParameterNode($node->type, $node->isReference, $node->isVariadic, $node->parameterName, $node->defaultValue);
    }
    public function setAttributeAwareNodeFactory(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory) : void
    {
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
    }
}
