<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\Type;

use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Node;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode;
use _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayShapeItemNode;
use _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface;
use _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareArrayShapeItemNodeFactory implements \_PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface, \_PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface
{
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    public function getOriginalNodeClass() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode::class;
    }
    public function isMatch(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        return \is_a($node, \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode::class, \true);
    }
    /**
     * @param ArrayShapeItemNode $node
     */
    public function create(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        $node->valueType = $this->attributeAwareNodeFactory->createFromNode($node->valueType, $docContent);
        return new \_PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayShapeItemNode($node->keyName, $node->optional, $node->valueType, $docContent);
    }
    public function setAttributeAwareNodeFactory(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory) : void
    {
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
    }
}
