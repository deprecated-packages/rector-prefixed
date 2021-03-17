<?php

declare (strict_types=1);
namespace Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactory\PhpDoc;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareMethodTagValueNode;
use Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface;
use Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareMethodTagValueNodeFactory implements \Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface, \Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface
{
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    public function getOriginalNodeClass() : string
    {
        return \PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueNode::class;
    }
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     */
    public function isMatch($node) : bool
    {
        return \is_a($node, \PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueNode::class, \true);
    }
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @param string $docContent
     */
    public function create($node, $docContent) : \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        $returnType = $this->attributizeReturnType($node, $docContent);
        foreach ($node->parameters as $key => $parameter) {
            $node->parameters[$key] = $this->attributeAwareNodeFactory->createFromNode($parameter, $docContent);
        }
        return new \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareMethodTagValueNode($node->isStatic, $returnType, $node->methodName, $node->parameters, $node->description);
    }
    /**
     * @param \Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory
     */
    public function setAttributeAwareNodeFactory($attributeAwareNodeFactory) : void
    {
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
    }
    /**
     * @param \PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueNode $methodTagValueNode
     * @param string $docContent
     */
    private function attributizeReturnType($methodTagValueNode, $docContent) : ?\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        if ($methodTagValueNode->returnType !== null) {
            return $this->createAttributeAwareReturnType($methodTagValueNode->returnType, $docContent);
        }
        return null;
    }
    /**
     * @param \PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode
     * @param string $docContent
     */
    private function createAttributeAwareReturnType($typeNode, $docContent) : \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        return $this->attributeAwareNodeFactory->createFromNode($typeNode, $docContent);
    }
}
