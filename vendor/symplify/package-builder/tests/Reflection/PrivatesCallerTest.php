<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Tests\Reflection;

use _PhpScoper006a73f0e455\PHPUnit\Framework\TestCase;
use Symplify\PackageBuilder\Reflection\PrivatesCaller;
use Symplify\PackageBuilder\Tests\Reflection\Source\SomeClassWithPrivateMethods;
final class PrivatesCallerTest extends \_PhpScoper006a73f0e455\PHPUnit\Framework\TestCase
{
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    protected function setUp() : void
    {
        $this->privatesCaller = new \Symplify\PackageBuilder\Reflection\PrivatesCaller();
    }
    public function testCallPrivateMethod() : void
    {
        $this->assertSame(5, $this->privatesCaller->callPrivateMethod(\Symplify\PackageBuilder\Tests\Reflection\Source\SomeClassWithPrivateMethods::class, 'getNumber'));
        $this->assertSame(5, $this->privatesCaller->callPrivateMethod(new \Symplify\PackageBuilder\Tests\Reflection\Source\SomeClassWithPrivateMethods(), 'getNumber'));
        $this->assertSame(40, $this->privatesCaller->callPrivateMethod(new \Symplify\PackageBuilder\Tests\Reflection\Source\SomeClassWithPrivateMethods(), 'plus10', 30));
    }
    public function testCallPrivateMethodWithReference() : void
    {
        $this->assertSame(20, $this->privatesCaller->callPrivateMethodWithReference(new \Symplify\PackageBuilder\Tests\Reflection\Source\SomeClassWithPrivateMethods(), 'multipleByTwo', 10));
    }
}
