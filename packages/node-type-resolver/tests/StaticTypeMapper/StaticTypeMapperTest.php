<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\StaticTypeMapper;

use Iterator;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IterableType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class StaticTypeMapperTest extends \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel::class);
        $this->staticTypeMapper = $this->getService(\_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper::class);
    }
    /**
     * @dataProvider provideDataForMapPHPStanPhpDocTypeNodeToPHPStanType()
     */
    public function testMapPHPStanPhpDocTypeNodeToPHPStanType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, string $expectedType) : void
    {
        $string = new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_('hey');
        $phpStanType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($typeNode, $string);
        $this->assertInstanceOf($expectedType, $phpStanType);
    }
    public function provideDataForMapPHPStanPhpDocTypeNodeToPHPStanType() : \Iterator
    {
        $genericTypeNode = new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode(new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('Traversable'), []);
        (yield [$genericTypeNode, \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericObjectType::class]);
        $genericTypeNode = new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode(new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('iterable'), [new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('string')]);
        (yield [$genericTypeNode, \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType::class]);
        (yield [new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('mixed'), \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType::class]);
    }
    public function testMapPHPStanTypeToPHPStanPhpDocTypeNode() : void
    {
        $iterableType = new \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType());
        $phpStanDocTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPHPStanPhpDocTypeNode($iterableType);
        $this->assertInstanceOf(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode::class, $phpStanDocTypeNode);
        /** @var ArrayTypeNode $phpStanDocTypeNode */
        $this->assertInstanceOf(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::class, $phpStanDocTypeNode->type);
    }
    public function testMixed() : void
    {
        $mixedType = new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        $phpStanDocTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPHPStanPhpDocTypeNode($mixedType);
        $this->assertInstanceOf(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::class, $phpStanDocTypeNode);
    }
    /**
     * @dataProvider provideDataForMapPhpParserNodePHPStanType()
     */
    public function testMapPhpParserNodePHPStanType(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $expectedType) : void
    {
        $phpStanType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($node);
        $this->assertInstanceOf($expectedType, $phpStanType);
    }
    public function provideDataForMapPhpParserNodePHPStanType() : \Iterator
    {
        (yield [new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier('iterable'), \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType::class]);
    }
}
