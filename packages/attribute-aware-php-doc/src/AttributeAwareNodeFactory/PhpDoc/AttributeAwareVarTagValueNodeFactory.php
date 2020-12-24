<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\PhpDoc;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareVarTagValueNodeFactory implements \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface, \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface
{
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    public function getOriginalNodeClass() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class;
    }
    public function isMatch(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        return \is_a($node, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class, \true);
    }
    /**
     * @param VarTagValueNode $node
     */
    public function create(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        $node->type = $this->attributeAwareNodeFactory->createFromNode($node->type, $docContent);
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode($node->type, $node->variableName, $node->description);
    }
    public function setAttributeAwareNodeFactory(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory) : void
    {
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
    }
}
