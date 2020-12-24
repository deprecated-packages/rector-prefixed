<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\StaticTypeMapper;

use Iterator;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IterableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class StaticTypeMapperTest extends \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel::class);
        $this->staticTypeMapper = $this->getService(\_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper::class);
    }
    /**
     * @dataProvider provideDataForMapPHPStanPhpDocTypeNodeToPHPStanType()
     */
    public function testMapPHPStanPhpDocTypeNodeToPHPStanType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, string $expectedType) : void
    {
        $string = new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_('hey');
        $phpStanType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($typeNode, $string);
        $this->assertInstanceOf($expectedType, $phpStanType);
    }
    public function provideDataForMapPHPStanPhpDocTypeNodeToPHPStanType() : \Iterator
    {
        $genericTypeNode = new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode(new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('Traversable'), []);
        (yield [$genericTypeNode, \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType::class]);
        $genericTypeNode = new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode(new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('iterable'), [new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('string')]);
        (yield [$genericTypeNode, \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType::class]);
        (yield [new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('mixed'), \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType::class]);
    }
    public function testMapPHPStanTypeToPHPStanPhpDocTypeNode() : void
    {
        $iterableType = new \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType());
        $phpStanDocTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPHPStanPhpDocTypeNode($iterableType);
        $this->assertInstanceOf(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode::class, $phpStanDocTypeNode);
        /** @var ArrayTypeNode $phpStanDocTypeNode */
        $this->assertInstanceOf(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::class, $phpStanDocTypeNode->type);
    }
    public function testMixed() : void
    {
        $mixedType = new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        $phpStanDocTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPHPStanPhpDocTypeNode($mixedType);
        $this->assertInstanceOf(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::class, $phpStanDocTypeNode);
    }
    /**
     * @dataProvider provideDataForMapPhpParserNodePHPStanType()
     */
    public function testMapPhpParserNodePHPStanType(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $expectedType) : void
    {
        $phpStanType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($node);
        $this->assertInstanceOf($expectedType, $phpStanType);
    }
    public function provideDataForMapPhpParserNodePHPStanType() : \Iterator
    {
        (yield [new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier('iterable'), \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType::class]);
    }
}
