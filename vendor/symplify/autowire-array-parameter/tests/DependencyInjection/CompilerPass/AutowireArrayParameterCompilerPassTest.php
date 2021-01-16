<?php

declare (strict_types=1);
namespace RectorPrefix20210116\Symplify\AutowireArrayParameter\Tests\DependencyInjection\CompilerPass;

use RectorPrefix20210116\Symplify\AutowireArrayParameter\Tests\HttpKernel\AutowireArrayParameterHttpKernel;
use RectorPrefix20210116\Symplify\AutowireArrayParameter\Tests\Source\ArrayShapeCollector;
use RectorPrefix20210116\Symplify\AutowireArrayParameter\Tests\Source\IterableCollector;
use RectorPrefix20210116\Symplify\AutowireArrayParameter\Tests\Source\SomeCollector;
use RectorPrefix20210116\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class AutowireArrayParameterCompilerPassTest extends \RectorPrefix20210116\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    protected function setUp() : void
    {
        $this->bootKernel(\RectorPrefix20210116\Symplify\AutowireArrayParameter\Tests\HttpKernel\AutowireArrayParameterHttpKernel::class);
    }
    public function test() : void
    {
        /** @var SomeCollector $someCollector */
        $someCollector = $this->getService(\RectorPrefix20210116\Symplify\AutowireArrayParameter\Tests\Source\SomeCollector::class);
        $this->assertCount(2, $someCollector->getCollected());
    }
    public function testArrayShape() : void
    {
        $arrayShapeCollector = $this->getService(\RectorPrefix20210116\Symplify\AutowireArrayParameter\Tests\Source\ArrayShapeCollector::class);
        $this->assertCount(2, $arrayShapeCollector->getCollected());
    }
    public function testIterable() : void
    {
        $iterableCollector = $this->getService(\RectorPrefix20210116\Symplify\AutowireArrayParameter\Tests\Source\IterableCollector::class);
        $this->assertCount(2, $iterableCollector->getCollected());
    }
}
