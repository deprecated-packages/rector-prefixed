<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser;

use Iterator;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocParser\TypeNodeAnalyzer;
use _PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class TypeNodeAnalyzerTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var string
     */
    private const INT = 'int';
    /**
     * @var TypeNodeAnalyzer
     */
    private $typeNodeAnalyzer;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel::class);
        $this->typeNodeAnalyzer = $this->getService(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocParser\TypeNodeAnalyzer::class);
    }
    /**
     * @dataProvider provideDataForArrayType()
     */
    public function testContainsArrayType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, bool $expectedContains) : void
    {
        $this->assertSame($expectedContains, $this->typeNodeAnalyzer->containsArrayType($typeNode));
    }
    public function provideDataForArrayType() : \Iterator
    {
        $arrayTypeNode = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode(new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode(self::INT));
        (yield [new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode(self::INT), \false]);
        (yield [$arrayTypeNode, \true]);
        (yield [new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode([$arrayTypeNode]), \true]);
    }
    /**
     * @dataProvider provideDataForIntersectionAndNotNullable()
     */
    public function testIsIntersectionAndNotNullable(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, bool $expectedIs) : void
    {
        $this->assertSame($expectedIs, $this->typeNodeAnalyzer->isIntersectionAndNotNullable($typeNode));
    }
    public function provideDataForIntersectionAndNotNullable() : \Iterator
    {
        (yield [new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode([new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode(self::INT)]), \true]);
        (yield [new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode([new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode(new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode(self::INT))]), \false]);
    }
}
