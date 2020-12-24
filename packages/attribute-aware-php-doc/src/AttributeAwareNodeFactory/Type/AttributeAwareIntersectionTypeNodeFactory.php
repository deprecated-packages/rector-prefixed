<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\Type;

use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIntersectionTypeNode;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareIntersectionTypeNodeFactory implements \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface, \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface
{
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    public function getOriginalNodeClass() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode::class;
    }
    public function isMatch(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        return \is_a($node, \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode::class, \true);
    }
    /**
     * @param IntersectionTypeNode $node
     */
    public function create(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        foreach ($node->types as $key => $intersectionedType) {
            $node->types[$key] = $this->attributeAwareNodeFactory->createFromNode($intersectionedType, $docContent);
        }
        return new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIntersectionTypeNode($node->types);
    }
    public function setAttributeAwareNodeFactory(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory) : void
    {
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
    }
}
