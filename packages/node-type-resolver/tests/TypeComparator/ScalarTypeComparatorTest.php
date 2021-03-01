<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Tests\TypeComparator;

use Iterator;
use PHPStan\Type\BooleanType;
use PHPStan\Type\ClassStringType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\NodeTypeResolver\TypeComparator\ScalarTypeComparator;
use RectorPrefix20210301\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class ScalarTypeComparatorTest extends \RectorPrefix20210301\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var ScalarTypeComparator
     */
    private $scalarTypeComparator;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->scalarTypeComparator = $this->getService(\Rector\NodeTypeResolver\TypeComparator\ScalarTypeComparator::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(\PHPStan\Type\Type $firstType, \PHPStan\Type\Type $secondType, bool $areExpectedEqual) : void
    {
        $areEqual = $this->scalarTypeComparator->areEqualScalar($firstType, $secondType);
        $this->assertSame($areExpectedEqual, $areEqual);
    }
    public function provideData() : \Iterator
    {
        (yield [new \PHPStan\Type\StringType(), new \PHPStan\Type\BooleanType(), \false]);
        (yield [new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType(), \true]);
        (yield [new \PHPStan\Type\StringType(), new \PHPStan\Type\ClassStringType(), \false]);
    }
}
