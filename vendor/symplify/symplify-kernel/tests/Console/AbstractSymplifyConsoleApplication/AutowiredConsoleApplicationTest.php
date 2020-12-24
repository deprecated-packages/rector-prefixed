<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\SymplifyKernel\Tests\Console\AbstractSymplifyConsoleApplication;

use _PhpScoper0a6b37af0871\Symfony\Component\Console\Application;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoper0a6b37af0871\Symplify\SymplifyKernel\Tests\HttpKernel\PackageBuilderTestingKernel;
final class AutowiredConsoleApplicationTest extends \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoper0a6b37af0871\Symplify\SymplifyKernel\Tests\HttpKernel\PackageBuilderTestingKernel::class);
    }
    public function test() : void
    {
        $application = $this->getService(\_PhpScoper0a6b37af0871\Symfony\Component\Console\Application::class);
        $this->assertInstanceOf(\_PhpScoper0a6b37af0871\Symfony\Component\Console\Application::class, $application);
    }
}
