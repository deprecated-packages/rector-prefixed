<?php

declare (strict_types=1);
namespace Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\PhpDoc;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareGenericTagValueNode;
use Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareGenericTagValueNodeFactory implements \Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface
{
    public function getOriginalNodeClass() : string
    {
        return \PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode::class;
    }
    public function isMatch(\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        return \is_a($node, \PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode::class, \true);
    }
    /**
     * @param GenericTagValueNode $node
     */
    public function create(\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        return new \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareGenericTagValueNode($node->value);
    }
}
