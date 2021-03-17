<?php

declare (strict_types=1);
namespace Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\PhpDoc;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueParameterNode;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareMethodTagValueParameterNode;
use Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface;
use Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareMethodTagValueParameterNodeFactory implements \Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface, \Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface
{
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    public function getOriginalNodeClass() : string
    {
        return \PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueParameterNode::class;
    }
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     */
    public function isMatch($node) : bool
    {
        return \is_a($node, \PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueParameterNode::class, \true);
    }
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @param string $docContent
     */
    public function create($node, $docContent) : \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        if ($node->type !== null) {
            $node->type = $this->attributeAwareNodeFactory->createFromNode($node->type, $docContent);
        }
        return new \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareMethodTagValueParameterNode($node->type, $node->isReference, $node->isVariadic, $node->parameterName, $node->defaultValue);
    }
    /**
     * @param \Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory
     */
    public function setAttributeAwareNodeFactory($attributeAwareNodeFactory) : void
    {
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
    }
}
