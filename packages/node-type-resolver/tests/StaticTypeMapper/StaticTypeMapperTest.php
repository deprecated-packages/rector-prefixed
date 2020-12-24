<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\StaticTypeMapper;

use Iterator;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\ClassStringType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\IterableType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class StaticTypeMapperTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel::class);
        $this->staticTypeMapper = $this->getService(\_PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper::class);
    }
    /**
     * @dataProvider provideDataForMapPHPStanPhpDocTypeNodeToPHPStanType()
     */
    public function testMapPHPStanPhpDocTypeNodeToPHPStanType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, string $expectedType) : void
    {
        $string = new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_('hey');
        $phpStanType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($typeNode, $string);
        $this->assertInstanceOf($expectedType, $phpStanType);
    }
    public function provideDataForMapPHPStanPhpDocTypeNodeToPHPStanType() : \Iterator
    {
        $genericTypeNode = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode(new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('Traversable'), []);
        (yield [$genericTypeNode, \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType::class]);
        $genericTypeNode = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode(new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('iterable'), [new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('string')]);
        (yield [$genericTypeNode, \_PhpScopere8e811afab72\PHPStan\Type\IterableType::class]);
        (yield [new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('mixed'), \_PhpScopere8e811afab72\PHPStan\Type\MixedType::class]);
    }
    public function testMapPHPStanTypeToPHPStanPhpDocTypeNode() : void
    {
        $iterableType = new \_PhpScopere8e811afab72\PHPStan\Type\IterableType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\ClassStringType());
        $phpStanDocTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPHPStanPhpDocTypeNode($iterableType);
        $this->assertInstanceOf(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode::class, $phpStanDocTypeNode);
        /** @var ArrayTypeNode $phpStanDocTypeNode */
        $this->assertInstanceOf(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::class, $phpStanDocTypeNode->type);
    }
    public function testMixed() : void
    {
        $mixedType = new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        $phpStanDocTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPHPStanPhpDocTypeNode($mixedType);
        $this->assertInstanceOf(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::class, $phpStanDocTypeNode);
    }
    /**
     * @dataProvider provideDataForMapPhpParserNodePHPStanType()
     */
    public function testMapPhpParserNodePHPStanType(\_PhpScopere8e811afab72\PhpParser\Node $node, string $expectedType) : void
    {
        $phpStanType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($node);
        $this->assertInstanceOf($expectedType, $phpStanType);
    }
    public function provideDataForMapPhpParserNodePHPStanType() : \Iterator
    {
        (yield [new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('iterable'), \_PhpScopere8e811afab72\PHPStan\Type\IterableType::class]);
    }
}
