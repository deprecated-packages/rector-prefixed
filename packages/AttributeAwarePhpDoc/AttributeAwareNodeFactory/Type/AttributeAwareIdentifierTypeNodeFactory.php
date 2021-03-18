<?php

declare (strict_types=1);
namespace Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\Type;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareIdentifierTypeNodeFactory implements \Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface
{
    public function getOriginalNodeClass() : string
    {
        return \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::class;
    }
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     */
    public function isMatch($node) : bool
    {
        return \is_a($node, \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::class, \true);
    }
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @param string $docContent
     */
    public function create($node, $docContent) : \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode($node->name);
    }
}
