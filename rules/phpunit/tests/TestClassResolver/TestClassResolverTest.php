<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\Tests\TestClassResolver;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp74\Tests\Rector\Property\DowngradeTypedPropertyRector\DowngradeTypedPropertyRectorTest;
use _PhpScoperb75b35f52b74\Rector\Php74\Rector\Property\TypedPropertyRector;
use _PhpScoperb75b35f52b74\Rector\Php74\Tests\Rector\Property\TypedPropertyRector\TypedPropertyRectorTest;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\TestClassResolver\TestClassResolver;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Tests\TestClassResolver\Source\SeeSomeClass;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Tests\TestClassResolver\Source\SeeSomeClassTest;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class TestClassResolverTest extends \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var TestClassResolver
     */
    private $testClassResolver;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel::class);
        $this->testClassResolver = $this->getService(\_PhpScoperb75b35f52b74\Rector\PHPUnit\TestClassResolver\TestClassResolver::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(string $rectorClass, string $expectedTestClass) : void
    {
        $testClass = $this->testClassResolver->resolveFromClassName($rectorClass);
        $this->assertSame($expectedTestClass, $testClass);
    }
    public function provideData() : \Iterator
    {
        (yield [\_PhpScoperb75b35f52b74\Rector\PHPUnit\Tests\TestClassResolver\Source\SeeSomeClass::class, \_PhpScoperb75b35f52b74\Rector\PHPUnit\Tests\TestClassResolver\Source\SeeSomeClassTest::class]);
        (yield [\_PhpScoperb75b35f52b74\Rector\Php74\Rector\Property\TypedPropertyRector::class, \_PhpScoperb75b35f52b74\Rector\Php74\Tests\Rector\Property\TypedPropertyRector\TypedPropertyRectorTest::class]);
        (yield [\_PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector::class, \_PhpScoperb75b35f52b74\Rector\DowngradePhp74\Tests\Rector\Property\DowngradeTypedPropertyRector\DowngradeTypedPropertyRectorTest::class]);
    }
}
