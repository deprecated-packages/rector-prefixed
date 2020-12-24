<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\PhpDoc;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueParameterNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareMethodTagValueParameterNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareMethodTagValueParameterNodeFactory implements \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface, \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface
{
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    public function getOriginalNodeClass() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueParameterNode::class;
    }
    public function isMatch(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        return \is_a($node, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueParameterNode::class, \true);
    }
    /**
     * @param MethodTagValueParameterNode $node
     */
    public function create(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        if ($node->type !== null) {
            $node->type = $this->attributeAwareNodeFactory->createFromNode($node->type, $docContent);
        }
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareMethodTagValueParameterNode($node->type, $node->isReference, $node->isVariadic, $node->parameterName, $node->defaultValue);
    }
    public function setAttributeAwareNodeFactory(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory) : void
    {
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
    }
}
