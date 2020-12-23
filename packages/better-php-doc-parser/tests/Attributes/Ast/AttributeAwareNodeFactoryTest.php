<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Tests\Attributes\Ast;

use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode;
use _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode;
use _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTextNode;
use _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePropertyTagValueNode;
use _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareNullableTypeNode;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScoper0a2ac50786fa\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class AttributeAwareNodeFactoryTest extends \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoper0a2ac50786fa\Rector\Core\HttpKernel\RectorKernel::class);
        $this->attributeAwareNodeFactory = static::$container->get(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory::class);
    }
    public function testPhpDocNodeAndChildren() : void
    {
        $phpDocNode = $this->createSomeTextDocNode();
        $attributeAwarePhpDocNode = $this->attributeAwareNodeFactory->createFromNode($phpDocNode, '');
        $this->assertInstanceOf(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode::class, $attributeAwarePhpDocNode);
        $this->assertInstanceOf(\_PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode::class, $attributeAwarePhpDocNode);
        $childNode = $attributeAwarePhpDocNode->children[0];
        $this->assertInstanceOf(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode::class, $childNode);
        $this->assertInstanceOf(\_PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTextNode::class, $childNode);
    }
    public function testPropertyTag() : void
    {
        $phpDocNode = $this->createPropertyDocNode();
        $attributeAwarePhpDocNode = $this->attributeAwareNodeFactory->createFromNode($phpDocNode, '');
        $childNode = $attributeAwarePhpDocNode->children[0];
        $this->assertInstanceOf(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode::class, $childNode);
        // test param tag
        /** @var PhpDocTagNode $childNode */
        $propertyTagValueNode = $childNode->value;
        $this->assertInstanceOf(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode::class, $propertyTagValueNode);
        $this->assertInstanceOf(\_PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePropertyTagValueNode::class, $propertyTagValueNode);
        // test nullable
        /** @var PropertyTagValueNode $propertyTagValueNode */
        $nullableTypeNode = $propertyTagValueNode->type;
        $this->assertInstanceOf(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode::class, $nullableTypeNode);
        $this->assertInstanceOf(\_PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareNullableTypeNode::class, $nullableTypeNode);
        // test type inside nullable
        /** @var NullableTypeNode $nullableTypeNode */
        $identifierTypeNode = $nullableTypeNode->type;
        $this->assertInstanceOf(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::class, $identifierTypeNode);
        $this->assertInstanceOf(\_PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode::class, $identifierTypeNode);
    }
    public function testAlreadyAttributeAware() : void
    {
        $attributeAwarePhpDocNode = new \_PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode([]);
        $returnedNode = $this->attributeAwareNodeFactory->createFromNode($attributeAwarePhpDocNode, '');
        $this->assertSame($returnedNode, $attributeAwarePhpDocNode);
    }
    /**
     * Creates doc block for:
     * some text
     */
    private function createSomeTextDocNode() : \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode([new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode('some text')]);
    }
    /**
     * Creates doc block for:
     * @property string|null $name
     */
    private function createPropertyDocNode() : \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
    {
        $nullableTypeNode = new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode(new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('string'));
        $propertyTagValueNode = new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode($nullableTypeNode, 'name', '');
        $children = [new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode('@property', $propertyTagValueNode)];
        return new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode($children);
    }
}
