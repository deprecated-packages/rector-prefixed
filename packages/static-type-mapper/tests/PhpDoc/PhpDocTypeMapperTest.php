<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Tests\PhpDoc;

use Iterator;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Nop;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\PHPStan\NameScopeFactory;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class PhpDocTypeMapperTest extends \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\_PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel::class);
        $this->phpDocTypeMapper = $this->getService(\_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper::class);
        $this->nameScopeFactory = $this->getService(\_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\PHPStan\NameScopeFactory::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, string $expectedPHPStanType) : void
    {
        $nop = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Nop();
        $nameScope = $this->nameScopeFactory->createNameScopeFromNode($nop);
        $phpStanType = $this->phpDocTypeMapper->mapToPHPStanType($typeNode, $nop, $nameScope);
        $this->assertInstanceOf($expectedPHPStanType, $phpStanType);
    }
    public function provideData() : \Iterator
    {
        $arrayShapeNode = new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode([new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode(null, \true, new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('string'))]);
        (yield [$arrayShapeNode, \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType::class]);
    }
}
