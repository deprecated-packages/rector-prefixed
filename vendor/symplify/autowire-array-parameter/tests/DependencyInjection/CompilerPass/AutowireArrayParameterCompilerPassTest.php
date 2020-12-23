<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\AutowireArrayParameter\Tests\DependencyInjection\CompilerPass;

use _PhpScoper0a2ac50786fa\Symplify\AutowireArrayParameter\Tests\HttpKernel\AutowireArrayParameterHttpKernel;
use _PhpScoper0a2ac50786fa\Symplify\AutowireArrayParameter\Tests\Source\SomeCollector;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class AutowireArrayParameterCompilerPassTest extends \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    public function test() : void
    {
        $this->bootKernel(\_PhpScoper0a2ac50786fa\Symplify\AutowireArrayParameter\Tests\HttpKernel\AutowireArrayParameterHttpKernel::class);
        /** @var SomeCollector $someCollector */
        $someCollector = $this->getService(\_PhpScoper0a2ac50786fa\Symplify\AutowireArrayParameter\Tests\Source\SomeCollector::class);
        $this->assertCount(2, $someCollector->getCollected());
    }
}
