<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\PhpDoc;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\UsesTagValueNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareUsesTagValueNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareUsesTagValueNodeFactory implements \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface
{
    public function getOriginalNodeClass() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\UsesTagValueNode::class;
    }
    public function isMatch(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        return \is_a($node, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\UsesTagValueNode::class, \true);
    }
    /**
     * @param UsesTagValueNode $node
     */
    public function create(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareUsesTagValueNode($node->type, $node->description);
    }
}
