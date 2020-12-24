<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\AutowireArrayParameter\Tests\DependencyInjection\CompilerPass;

use _PhpScoper2a4e7ab1ecbc\Symplify\AutowireArrayParameter\Tests\HttpKernel\AutowireArrayParameterHttpKernel;
use _PhpScoper2a4e7ab1ecbc\Symplify\AutowireArrayParameter\Tests\Source\SomeCollector;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class AutowireArrayParameterCompilerPassTest extends \_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    public function test() : void
    {
        $this->bootKernel(\_PhpScoper2a4e7ab1ecbc\Symplify\AutowireArrayParameter\Tests\HttpKernel\AutowireArrayParameterHttpKernel::class);
        /** @var SomeCollector $someCollector */
        $someCollector = $this->getService(\_PhpScoper2a4e7ab1ecbc\Symplify\AutowireArrayParameter\Tests\Source\SomeCollector::class);
        $this->assertCount(2, $someCollector->getCollected());
    }
}
