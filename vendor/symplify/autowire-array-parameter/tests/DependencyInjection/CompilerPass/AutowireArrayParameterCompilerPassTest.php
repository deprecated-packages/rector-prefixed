<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\AutowireArrayParameter\Tests\DependencyInjection\CompilerPass;

use _PhpScoper0a6b37af0871\Symplify\AutowireArrayParameter\Tests\HttpKernel\AutowireArrayParameterHttpKernel;
use _PhpScoper0a6b37af0871\Symplify\AutowireArrayParameter\Tests\Source\SomeCollector;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class AutowireArrayParameterCompilerPassTest extends \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    public function test() : void
    {
        $this->bootKernel(\_PhpScoper0a6b37af0871\Symplify\AutowireArrayParameter\Tests\HttpKernel\AutowireArrayParameterHttpKernel::class);
        /** @var SomeCollector $someCollector */
        $someCollector = $this->getService(\_PhpScoper0a6b37af0871\Symplify\AutowireArrayParameter\Tests\Source\SomeCollector::class);
        $this->assertCount(2, $someCollector->getCollected());
    }
}
