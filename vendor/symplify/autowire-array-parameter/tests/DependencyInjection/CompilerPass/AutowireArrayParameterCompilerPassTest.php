<?php

declare (strict_types=1);
namespace Symplify\AutowireArrayParameter\Tests\DependencyInjection\CompilerPass;

use Symplify\AutowireArrayParameter\Tests\HttpKernel\AutowireArrayParameterHttpKernel;
use Symplify\AutowireArrayParameter\Tests\Source\SomeCollector;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class AutowireArrayParameterCompilerPassTest extends \Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    public function test() : void
    {
        $this->bootKernel(\Symplify\AutowireArrayParameter\Tests\HttpKernel\AutowireArrayParameterHttpKernel::class);
        /** @var SomeCollector $someCollector */
        $someCollector = $this->getService(\Symplify\AutowireArrayParameter\Tests\Source\SomeCollector::class);
        $this->assertCount(2, $someCollector->getCollected());
    }
}
