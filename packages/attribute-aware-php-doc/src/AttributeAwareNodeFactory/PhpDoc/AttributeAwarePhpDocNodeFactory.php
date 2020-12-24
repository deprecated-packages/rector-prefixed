<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\PhpDoc;

use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use _PhpScoper0a6b37af0871\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
final class AttributeAwarePhpDocNodeFactory implements \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface, \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface
{
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    /**
     * @var PhpDocNodeTraverser
     */
    private $phpDocNodeTraverser;
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\SimplePhpDocParser\PhpDocNodeTraverser $phpDocNodeTraverser)
    {
        $this->phpDocNodeTraverser = $phpDocNodeTraverser;
    }
    public function getOriginalNodeClass() : string
    {
        return \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode::class;
    }
    public function isMatch(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        return \is_a($node, \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode::class, \true);
    }
    /**
     * @param PhpDocNode $node
     */
    public function create(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        $this->phpDocNodeTraverser->traverseWithCallable($node, $docContent, function (\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node $node) use($docContent) : AttributeAwareNodeInterface {
            if ($node instanceof \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface) {
                return $node;
            }
            return $this->attributeAwareNodeFactory->createFromNode($node, $docContent);
        });
        return new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode($node->children);
    }
    public function setAttributeAwareNodeFactory(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory) : void
    {
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
    }
}
