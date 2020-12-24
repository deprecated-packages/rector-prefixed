<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\Tests\TestClassResolver;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper0a6b37af0871\Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector;
use _PhpScoper0a6b37af0871\Rector\DowngradePhp74\Tests\Rector\Property\DowngradeTypedPropertyRector\DowngradeTypedPropertyRectorTest;
use _PhpScoper0a6b37af0871\Rector\Php74\Rector\Property\TypedPropertyRector;
use _PhpScoper0a6b37af0871\Rector\Php74\Tests\Rector\Property\TypedPropertyRector\TypedPropertyRectorTest;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\TestClassResolver\TestClassResolver;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\Tests\TestClassResolver\Source\SeeSomeClass;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\Tests\TestClassResolver\Source\SeeSomeClassTest;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class TestClassResolverTest extends \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var TestClassResolver
     */
    private $testClassResolver;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel::class);
        $this->testClassResolver = $this->getService(\_PhpScoper0a6b37af0871\Rector\PHPUnit\TestClassResolver\TestClassResolver::class);
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
        (yield [\_PhpScoper0a6b37af0871\Rector\PHPUnit\Tests\TestClassResolver\Source\SeeSomeClass::class, \_PhpScoper0a6b37af0871\Rector\PHPUnit\Tests\TestClassResolver\Source\SeeSomeClassTest::class]);
        (yield [\_PhpScoper0a6b37af0871\Rector\Php74\Rector\Property\TypedPropertyRector::class, \_PhpScoper0a6b37af0871\Rector\Php74\Tests\Rector\Property\TypedPropertyRector\TypedPropertyRectorTest::class]);
        (yield [\_PhpScoper0a6b37af0871\Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector::class, \_PhpScoper0a6b37af0871\Rector\DowngradePhp74\Tests\Rector\Property\DowngradeTypedPropertyRector\DowngradeTypedPropertyRectorTest::class]);
    }
}
