<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\Tests\TestClassResolver;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel;
use _PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp74\Tests\Rector\Property\DowngradeTypedPropertyRector\DowngradeTypedPropertyRectorTest;
use _PhpScopere8e811afab72\Rector\Php74\Rector\Property\TypedPropertyRector;
use _PhpScopere8e811afab72\Rector\Php74\Tests\Rector\Property\TypedPropertyRector\TypedPropertyRectorTest;
use _PhpScopere8e811afab72\Rector\PHPUnit\TestClassResolver\TestClassResolver;
use _PhpScopere8e811afab72\Rector\PHPUnit\Tests\TestClassResolver\Source\SeeSomeClass;
use _PhpScopere8e811afab72\Rector\PHPUnit\Tests\TestClassResolver\Source\SeeSomeClassTest;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class TestClassResolverTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var TestClassResolver
     */
    private $testClassResolver;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel::class);
        $this->testClassResolver = $this->getService(\_PhpScopere8e811afab72\Rector\PHPUnit\TestClassResolver\TestClassResolver::class);
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
        (yield [\_PhpScopere8e811afab72\Rector\PHPUnit\Tests\TestClassResolver\Source\SeeSomeClass::class, \_PhpScopere8e811afab72\Rector\PHPUnit\Tests\TestClassResolver\Source\SeeSomeClassTest::class]);
        (yield [\_PhpScopere8e811afab72\Rector\Php74\Rector\Property\TypedPropertyRector::class, \_PhpScopere8e811afab72\Rector\Php74\Tests\Rector\Property\TypedPropertyRector\TypedPropertyRectorTest::class]);
        (yield [\_PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector::class, \_PhpScopere8e811afab72\Rector\DowngradePhp74\Tests\Rector\Property\DowngradeTypedPropertyRector\DowngradeTypedPropertyRectorTest::class]);
    }
}
