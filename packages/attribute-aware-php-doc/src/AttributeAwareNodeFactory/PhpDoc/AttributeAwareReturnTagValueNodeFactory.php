<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\PhpDoc;

use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareReturnTagValueNode;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareReturnTagValueNodeFactory implements \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface, \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface
{
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    public function getOriginalNodeClass() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class;
    }
    public function isMatch(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        return \is_a($node, \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class, \true);
    }
    /**
     * @param ReturnTagValueNode $node
     */
    public function create(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        $node->type = $this->attributeAwareNodeFactory->createFromNode($node->type, $docContent);
        return new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareReturnTagValueNode($node->type, $node->description);
    }
    public function setAttributeAwareNodeFactory(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory) : void
    {
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
    }
}
