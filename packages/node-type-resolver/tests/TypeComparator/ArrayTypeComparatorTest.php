<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Tests\TypeComparator;

use Iterator;
use PHPStan\Type\ArrayType;
use PHPStan\Type\ClassStringType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Generic\GenericClassStringType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\NodeTypeResolver\Tests\TypeComparator\Source\SomeGenericTypeObject;
use Rector\NodeTypeResolver\TypeComparator\ArrayTypeComparator;
use Rector\StaticTypeMapper\TypeFactory\UnionTypeFactory;
use RectorPrefix20210308\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class ArrayTypeComparatorTest extends \RectorPrefix20210308\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var ArrayTypeComparator
     */
    private $arrayTypeComparator;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->arrayTypeComparator = $this->getService(\Rector\NodeTypeResolver\TypeComparator\ArrayTypeComparator::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(\PHPStan\Type\ArrayType $firstArrayType, \PHPStan\Type\ArrayType $secondArrayType, bool $areExpectedEqual) : void
    {
        $areEqual = $this->arrayTypeComparator->isSubtype($firstArrayType, $secondArrayType);
        $this->assertSame($areExpectedEqual, $areEqual);
    }
    /**
     * @return Iterator<ArrayType[]|bool[]>
     */
    public function provideData() : \Iterator
    {
        $unionTypeFactory = new \Rector\StaticTypeMapper\TypeFactory\UnionTypeFactory();
        $classStringKeysArrayType = new \PHPStan\Type\ArrayType(new \PHPStan\Type\StringType(), new \PHPStan\Type\ClassStringType());
        $stringArrayType = new \PHPStan\Type\ArrayType(new \PHPStan\Type\StringType(), new \PHPStan\Type\MixedType());
        (yield [$stringArrayType, $classStringKeysArrayType, \false]);
        $genericClassStringType = new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Rector\NodeTypeResolver\Tests\TypeComparator\Source\SomeGenericTypeObject::class));
        $constantArrayType = new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0)], [$unionTypeFactory->createUnionObjectType([$genericClassStringType, $genericClassStringType])]);
        (yield [$constantArrayType, $stringArrayType, \false]);
    }
}
