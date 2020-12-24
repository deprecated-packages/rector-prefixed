<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\PhpDoc;

use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use _PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
final class AttributeAwarePhpDocNodeFactory implements \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface, \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface
{
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    /**
     * @var PhpDocNodeTraverser
     */
    private $phpDocNodeTraverser;
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\PhpDocNodeTraverser $phpDocNodeTraverser)
    {
        $this->phpDocNodeTraverser = $phpDocNodeTraverser;
    }
    public function getOriginalNodeClass() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode::class;
    }
    public function isMatch(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        return \is_a($node, \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode::class, \true);
    }
    /**
     * @param PhpDocNode $node
     */
    public function create(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        $this->phpDocNodeTraverser->traverseWithCallable($node, $docContent, function (\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node $node) use($docContent) : AttributeAwareNodeInterface {
            if ($node instanceof \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface) {
                return $node;
            }
            return $this->attributeAwareNodeFactory->createFromNode($node, $docContent);
        });
        return new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode($node->children);
    }
    public function setAttributeAwareNodeFactory(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory) : void
    {
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
    }
}
