<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\Attributes\Ast;

use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\NullableTypeNode;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTextNode;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePropertyTagValueNode;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareNullableTypeNode;
use Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use Rector\Core\HttpKernel\RectorKernel;
use RectorPrefix20210106\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class AttributeAwareNodeFactoryTest extends \RectorPrefix20210106\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->attributeAwareNodeFactory = static::$container->get(\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory::class);
    }
    public function testPhpDocNodeAndChildren() : void
    {
        $phpDocNode = $this->createSomeTextDocNode();
        $attributeAwarePhpDocNode = $this->attributeAwareNodeFactory->createFromNode($phpDocNode, '');
        $this->assertInstanceOf(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode::class, $attributeAwarePhpDocNode);
        $this->assertInstanceOf(\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode::class, $attributeAwarePhpDocNode);
        $childNode = $attributeAwarePhpDocNode->children[0];
        $this->assertInstanceOf(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode::class, $childNode);
        $this->assertInstanceOf(\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTextNode::class, $childNode);
    }
    public function testPropertyTag() : void
    {
        $phpDocNode = $this->createPropertyDocNode();
        $attributeAwarePhpDocNode = $this->attributeAwareNodeFactory->createFromNode($phpDocNode, '');
        $childNode = $attributeAwarePhpDocNode->children[0];
        $this->assertInstanceOf(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode::class, $childNode);
        // test param tag
        /** @var PhpDocTagNode $childNode */
        $propertyTagValueNode = $childNode->value;
        $this->assertInstanceOf(\PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode::class, $propertyTagValueNode);
        $this->assertInstanceOf(\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePropertyTagValueNode::class, $propertyTagValueNode);
        // test nullable
        /** @var PropertyTagValueNode $propertyTagValueNode */
        $nullableTypeNode = $propertyTagValueNode->type;
        $this->assertInstanceOf(\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode::class, $nullableTypeNode);
        $this->assertInstanceOf(\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareNullableTypeNode::class, $nullableTypeNode);
        // test type inside nullable
        /** @var NullableTypeNode $nullableTypeNode */
        $identifierTypeNode = $nullableTypeNode->type;
        $this->assertInstanceOf(\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::class, $identifierTypeNode);
        $this->assertInstanceOf(\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode::class, $identifierTypeNode);
    }
    public function testAlreadyAttributeAware() : void
    {
        $attributeAwarePhpDocNode = new \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode([]);
        $returnedNode = $this->attributeAwareNodeFactory->createFromNode($attributeAwarePhpDocNode, '');
        $this->assertSame($returnedNode, $attributeAwarePhpDocNode);
    }
    /**
     * Creates doc block for:
     * some text
     */
    private function createSomeTextDocNode() : \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
    {
        return new \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode([new \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode('some text')]);
    }
    /**
     * Creates doc block for:
     * @property string|null $name
     */
    private function createPropertyDocNode() : \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
    {
        $nullableTypeNode = new \PHPStan\PhpDocParser\Ast\Type\NullableTypeNode(new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('string'));
        $propertyTagValueNode = new \PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode($nullableTypeNode, 'name', '');
        $children = [new \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode('@property', $propertyTagValueNode)];
        return new \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode($children);
    }
}
