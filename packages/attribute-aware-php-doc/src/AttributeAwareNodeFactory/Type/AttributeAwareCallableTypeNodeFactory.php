<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\Type;

use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\CallableTypeNode;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareCallableTypeNode;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareCallableTypeNodeFactory implements \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface, \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface
{
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    public function getOriginalNodeClass() : string
    {
        return \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\CallableTypeNode::class;
    }
    public function isMatch(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        return \is_a($node, \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\CallableTypeNode::class, \true);
    }
    /**
     * @param CallableTypeNode $node
     */
    public function create(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        $identifier = $this->attributeAwareNodeFactory->createFromNode($node->identifier, $docContent);
        foreach ($node->parameters as $key => $parameter) {
            $node->parameters[$key] = $this->attributeAwareNodeFactory->createFromNode($parameter, $docContent);
        }
        $returnType = $this->attributeAwareNodeFactory->createFromNode($node->returnType, $docContent);
        return new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareCallableTypeNode($identifier, $node->parameters, $returnType);
    }
    public function setAttributeAwareNodeFactory(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory) : void
    {
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
    }
}
