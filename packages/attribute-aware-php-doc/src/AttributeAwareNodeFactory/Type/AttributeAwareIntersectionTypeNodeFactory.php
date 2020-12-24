<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\Type;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIntersectionTypeNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareIntersectionTypeNodeFactory implements \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface, \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface
{
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    public function getOriginalNodeClass() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode::class;
    }
    public function isMatch(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        return \is_a($node, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode::class, \true);
    }
    /**
     * @param IntersectionTypeNode $node
     */
    public function create(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        foreach ($node->types as $key => $intersectionedType) {
            $node->types[$key] = $this->attributeAwareNodeFactory->createFromNode($intersectionedType, $docContent);
        }
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIntersectionTypeNode($node->types);
    }
    public function setAttributeAwareNodeFactory(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory) : void
    {
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
    }
}
