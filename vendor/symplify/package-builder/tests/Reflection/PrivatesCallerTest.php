<?php

declare (strict_types=1);
namespace RectorPrefix20210322\Symplify\PackageBuilder\Tests\Reflection;

use Iterator;
use RectorPrefix20210322\PHPUnit\Framework\TestCase;
use RectorPrefix20210322\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use RectorPrefix20210322\Symplify\PackageBuilder\Tests\Reflection\Source\SomeClassWithPrivateMethods;
final class PrivatesCallerTest extends \RectorPrefix20210322\PHPUnit\Framework\TestCase
{
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    protected function setUp() : void
    {
        $this->privatesCaller = new \RectorPrefix20210322\Symplify\PackageBuilder\Reflection\PrivatesCaller();
    }
    /**
     * @dataProvider provideData()
     * @param mixed[]|int[] $arguments
     */
    public function test($object, string $methodName, array $arguments, int $expectedResult) : void
    {
        $result = $this->privatesCaller->callPrivateMethod($object, $methodName, $arguments);
        $this->assertSame($expectedResult, $result);
    }
    public function provideData() : \Iterator
    {
        (yield [\RectorPrefix20210322\Symplify\PackageBuilder\Tests\Reflection\Source\SomeClassWithPrivateMethods::class, 'getNumber', [], 5]);
        (yield [new \RectorPrefix20210322\Symplify\PackageBuilder\Tests\Reflection\Source\SomeClassWithPrivateMethods(), 'getNumber', [], 5]);
        (yield [new \RectorPrefix20210322\Symplify\PackageBuilder\Tests\Reflection\Source\SomeClassWithPrivateMethods(), 'plus10', [30], 40]);
    }
    /**
     * @dataProvider provideDataReference()
     */
    public function testReference(\RectorPrefix20210322\Symplify\PackageBuilder\Tests\Reflection\Source\SomeClassWithPrivateMethods $someClassWithPrivateMethods, string $methodName, int $referencedArgument, int $expectedResult) : void
    {
        $result = $this->privatesCaller->callPrivateMethodWithReference($someClassWithPrivateMethods, $methodName, $referencedArgument);
        $this->assertSame($expectedResult, $result);
    }
    public function provideDataReference() : \Iterator
    {
        (yield [new \RectorPrefix20210322\Symplify\PackageBuilder\Tests\Reflection\Source\SomeClassWithPrivateMethods(), 'multipleByTwo', 10, 20]);
    }
}
