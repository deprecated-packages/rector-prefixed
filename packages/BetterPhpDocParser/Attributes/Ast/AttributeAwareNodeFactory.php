<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Attributes\Ast;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode;
use PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayShapeItemNode;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode;
use Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface;
use Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use RectorPrefix20210320\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
/**
 * @see \Rector\Tests\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactoryTest
 */
final class AttributeAwareNodeFactory
{
    /**
     * @var AttributeNodeAwareFactoryInterface[]
     */
    private $attributeAwareNodeFactories = [];
    /**
     * @var PhpDocNodeTraverser
     */
    private $phpDocNodeTraverser;
    /**
     * @param AttributeNodeAwareFactoryInterface[] $attributeAwareNodeFactories
     */
    public function __construct(array $attributeAwareNodeFactories, \RectorPrefix20210320\Symplify\SimplePhpDocParser\PhpDocNodeTraverser $phpDocNodeTraverser)
    {
        foreach ($attributeAwareNodeFactories as $attributeAwareNodeFactory) {
            // prevents cyclic dependency
            if ($attributeAwareNodeFactory instanceof \Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface) {
                $attributeAwareNodeFactory->setAttributeAwareNodeFactory($this);
            }
        }
        $this->attributeAwareNodeFactories = $attributeAwareNodeFactories;
        $this->phpDocNodeTraverser = $phpDocNodeTraverser;
    }
    /**
     * @template T of \PHPStan\PhpDocParser\Ast\Node
     * @param T $node
     * @return T
     */
    public function createFromNode(\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \PHPStan\PhpDocParser\Ast\Node
    {
        $node = $this->phpDocNodeTraverser->traverseWithCallable($node, $docContent, function (\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : Node {
            if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\UnionTypeNode && !$node instanceof \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode) {
                return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode($node->types, $docContent);
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode && !$node instanceof \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayShapeItemNode) {
                return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayShapeItemNode($node->keyName, $node->optional, $node->valueType, $docContent);
            }
            return $node;
        });
        foreach ($this->attributeAwareNodeFactories as $attributeAwareNodeFactory) {
            if (!$attributeAwareNodeFactory->isMatch($node)) {
                continue;
            }
            return $attributeAwareNodeFactory->create($node, $docContent);
        }
        return $node;
    }
}
