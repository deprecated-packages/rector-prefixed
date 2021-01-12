<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser;

use Iterator;
use PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use PHPStan\PhpDocParser\Ast\Type\NullableTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use Rector\BetterPhpDocParser\PhpDocParser\TypeNodeAnalyzer;
use Rector\Core\HttpKernel\RectorKernel;
use RectorPrefix20210112\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class TypeNodeAnalyzerTest extends \RectorPrefix20210112\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->typeNodeAnalyzer = $this->getService(\Rector\BetterPhpDocParser\PhpDocParser\TypeNodeAnalyzer::class);
    }
    /**
     * @dataProvider provideDataForArrayType()
     */
    public function testContainsArrayType(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, bool $expectedContains) : void
    {
        $this->assertSame($expectedContains, $this->typeNodeAnalyzer->containsArrayType($typeNode));
    }
    public function provideDataForArrayType() : \Iterator
    {
        $arrayTypeNode = new \PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode(new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode(self::INT));
        (yield [new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode(self::INT), \false]);
        (yield [$arrayTypeNode, \true]);
        (yield [new \PHPStan\PhpDocParser\Ast\Type\UnionTypeNode([$arrayTypeNode]), \true]);
    }
    /**
     * @dataProvider provideDataForIntersectionAndNotNullable()
     */
    public function testIsIntersectionAndNotNullable(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, bool $expectedIs) : void
    {
        $this->assertSame($expectedIs, $this->typeNodeAnalyzer->isIntersectionAndNotNullable($typeNode));
    }
    public function provideDataForIntersectionAndNotNullable() : \Iterator
    {
        (yield [new \PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode([new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode(self::INT)]), \true]);
        (yield [new \PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode([new \PHPStan\PhpDocParser\Ast\Type\NullableTypeNode(new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode(self::INT))]), \false]);
    }
}
