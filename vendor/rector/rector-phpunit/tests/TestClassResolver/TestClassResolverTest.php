<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\TestClassResolver;

use Iterator;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\PHPUnit\TestClassResolver\TestClassResolver;
use Rector\PHPUnit\Tests\TestClassResolver\Source\SeeSomeClass;
use Rector\PHPUnit\Tests\TestClassResolver\Source\SeeSomeClassTest;
use RectorPrefix20210321\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class TestClassResolverTest extends \RectorPrefix20210321\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var TestClassResolver
     */
    private $testClassResolver;
    protected function setUp() : void
    {
        $this->bootKernelWithConfigs(\Rector\Core\HttpKernel\RectorKernel::class, [__DIR__ . '/../../config/config.php']);
        $this->testClassResolver = $this->getService(\Rector\PHPUnit\TestClassResolver\TestClassResolver::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(string $rectorClass, string $expectedTestClass) : void
    {
        $testClass = $this->testClassResolver->resolveFromClassName($rectorClass);
        $this->assertSame($expectedTestClass, $testClass);
    }
    /**
     * @return Iterator<mixed>
     */
    public function provideData() : \Iterator
    {
        (yield [\Rector\PHPUnit\Tests\TestClassResolver\Source\SeeSomeClass::class, \Rector\PHPUnit\Tests\TestClassResolver\Source\SeeSomeClassTest::class]);
    }
}
