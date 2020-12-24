<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocParser;

use Iterator;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocParser\TypeNodeAnalyzer;
use _PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class TypeNodeAnalyzerTest extends \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\_PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel::class);
        $this->typeNodeAnalyzer = $this->getService(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocParser\TypeNodeAnalyzer::class);
    }
    /**
     * @dataProvider provideDataForArrayType()
     */
    public function testContainsArrayType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, bool $expectedContains) : void
    {
        $this->assertSame($expectedContains, $this->typeNodeAnalyzer->containsArrayType($typeNode));
    }
    public function provideDataForArrayType() : \Iterator
    {
        $arrayTypeNode = new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode(new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode(self::INT));
        (yield [new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode(self::INT), \false]);
        (yield [$arrayTypeNode, \true]);
        (yield [new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode([$arrayTypeNode]), \true]);
    }
    /**
     * @dataProvider provideDataForIntersectionAndNotNullable()
     */
    public function testIsIntersectionAndNotNullable(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, bool $expectedIs) : void
    {
        $this->assertSame($expectedIs, $this->typeNodeAnalyzer->isIntersectionAndNotNullable($typeNode));
    }
    public function provideDataForIntersectionAndNotNullable() : \Iterator
    {
        (yield [new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode([new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode(self::INT)]), \true]);
        (yield [new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode([new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode(new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode(self::INT))]), \false]);
    }
}
