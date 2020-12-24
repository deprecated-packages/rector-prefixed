<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Tests\PhpDoc;

use Iterator;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Nop;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PHPStan\NameScopeFactory;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class PhpDocTypeMapperTest extends \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var PhpDocTypeMapper
     */
    private $phpDocTypeMapper;
    /**
     * @var NameScopeFactory
     */
    private $nameScopeFactory;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel::class);
        $this->phpDocTypeMapper = $this->getService(\_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper::class);
        $this->nameScopeFactory = $this->getService(\_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PHPStan\NameScopeFactory::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, string $expectedPHPStanType) : void
    {
        $nop = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Nop();
        $nameScope = $this->nameScopeFactory->createNameScopeFromNode($nop);
        $phpStanType = $this->phpDocTypeMapper->mapToPHPStanType($typeNode, $nop, $nameScope);
        $this->assertInstanceOf($expectedPHPStanType, $phpStanType);
    }
    public function provideData() : \Iterator
    {
        $arrayShapeNode = new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode([new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode(null, \true, new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('string'))]);
        (yield [$arrayShapeNode, \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType::class]);
    }
}
