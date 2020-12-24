<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\Type;

use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode;
use _PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayShapeNode;
use _PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareArrayShapeNodeFactory implements \_PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface, \_PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface
{
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    public function getOriginalNodeClass() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode::class;
    }
    public function isMatch(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        return \is_a($node, \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode::class, \true);
    }
    /**
     * @param ArrayShapeNode $node
     */
    public function create(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        $items = [];
        foreach ($node->items as $item) {
            $items[] = $this->attributeAwareNodeFactory->createFromNode($item, $docContent);
        }
        return new \_PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayShapeNode($items);
    }
    public function setAttributeAwareNodeFactory(\_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory) : void
    {
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
    }
}
