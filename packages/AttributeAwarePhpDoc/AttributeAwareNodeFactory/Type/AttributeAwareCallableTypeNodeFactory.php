<?php

declare (strict_types=1);
namespace Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\Type;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\Type\CallableTypeNode;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareCallableTypeNode;
use Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface;
use Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
final class AttributeAwareCallableTypeNodeFactory implements \Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface, \Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface
{
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    public function isMatch(\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        return \is_a($node, \PHPStan\PhpDocParser\Ast\Type\CallableTypeNode::class, \true);
    }
    /**
     * @param CallableTypeNode $node
     * @return AttributeAwareCallableTypeNode
     */
    public function create(\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \PHPStan\PhpDocParser\Ast\Node
    {
        $identifier = $this->attributeAwareNodeFactory->createFromNode($node->identifier, $docContent);
        foreach ($node->parameters as $key => $parameter) {
            $node->parameters[$key] = $this->attributeAwareNodeFactory->createFromNode($parameter, $docContent);
        }
        $returnType = $this->attributeAwareNodeFactory->createFromNode($node->returnType, $docContent);
        return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareCallableTypeNode($identifier, $node->parameters, $returnType);
    }
    public function setAttributeAwareNodeFactory(\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory) : void
    {
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
    }
}
