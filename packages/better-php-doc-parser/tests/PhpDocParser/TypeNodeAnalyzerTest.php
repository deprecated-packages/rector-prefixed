<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Tests\PhpDocParser;

use Iterator;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocParser\TypeNodeAnalyzer;
use _PhpScoper0a2ac50786fa\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class TypeNodeAnalyzerTest extends \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\_PhpScoper0a2ac50786fa\Rector\Core\HttpKernel\RectorKernel::class);
        $this->typeNodeAnalyzer = self::$container->get(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocParser\TypeNodeAnalyzer::class);
    }
    /**
     * @dataProvider provideDataForArrayType()
     */
    public function testContainsArrayType(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, bool $expectedContains) : void
    {
        $this->assertSame($expectedContains, $this->typeNodeAnalyzer->containsArrayType($typeNode));
    }
    public function provideDataForArrayType() : \Iterator
    {
        $arrayTypeNode = new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode(new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode(self::INT));
        (yield [new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode(self::INT), \false]);
        (yield [$arrayTypeNode, \true]);
        (yield [new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode([$arrayTypeNode]), \true]);
    }
    /**
     * @dataProvider provideDataForIntersectionAndNotNullable()
     */
    public function testIsIntersectionAndNotNullable(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, bool $expectedIs) : void
    {
        $this->assertSame($expectedIs, $this->typeNodeAnalyzer->isIntersectionAndNotNullable($typeNode));
    }
    public function provideDataForIntersectionAndNotNullable() : \Iterator
    {
        (yield [new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode([new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode(self::INT)]), \true]);
        (yield [new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode([new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode(new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode(self::INT))]), \false]);
    }
}
