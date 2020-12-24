<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\StaticTypeMapper\Tests\PhpDoc;

use Iterator;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Nop;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\PHPStan\NameScopeFactory;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class PhpDocTypeMapperTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\_PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel::class);
        $this->phpDocTypeMapper = $this->getService(\_PhpScopere8e811afab72\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper::class);
        $this->nameScopeFactory = $this->getService(\_PhpScopere8e811afab72\Rector\StaticTypeMapper\PHPStan\NameScopeFactory::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, string $expectedPHPStanType) : void
    {
        $nop = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Nop();
        $nameScope = $this->nameScopeFactory->createNameScopeFromNode($nop);
        $phpStanType = $this->phpDocTypeMapper->mapToPHPStanType($typeNode, $nop, $nameScope);
        $this->assertInstanceOf($expectedPHPStanType, $phpStanType);
    }
    public function provideData() : \Iterator
    {
        $arrayShapeNode = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode([new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode(null, \true, new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('string'))]);
        (yield [$arrayShapeNode, \_PhpScopere8e811afab72\PHPStan\Type\ArrayType::class]);
    }
}
