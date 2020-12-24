<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\PhpDoc;

use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\UsesTagValueNode;
use _PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareUsesTagValueNode;
use _PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareUsesTagValueNodeFactory implements \_PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface
{
    public function getOriginalNodeClass() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\UsesTagValueNode::class;
    }
    public function isMatch(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        return \is_a($node, \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\UsesTagValueNode::class, \true);
    }
    /**
     * @param UsesTagValueNode $node
     */
    public function create(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        return new \_PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareUsesTagValueNode($node->type, $node->description);
    }
}
