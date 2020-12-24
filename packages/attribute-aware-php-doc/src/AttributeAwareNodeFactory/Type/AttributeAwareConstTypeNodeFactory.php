<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\Type;

use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ConstTypeNode;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareConstTypeNode;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareConstTypeNodeFactory implements \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface
{
    public function getOriginalNodeClass() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ConstTypeNode::class;
    }
    public function isMatch(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        return \is_a($node, \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ConstTypeNode::class, \true);
    }
    /**
     * @param ConstTypeNode $node
     */
    public function create(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        return new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareConstTypeNode($node->constExpr);
    }
}
