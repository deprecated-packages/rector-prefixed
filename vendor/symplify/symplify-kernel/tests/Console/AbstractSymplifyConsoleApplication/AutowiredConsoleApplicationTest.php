<?php

declare (strict_types=1);
namespace RectorPrefix20210103\Symplify\SymplifyKernel\Tests\Console\AbstractSymplifyConsoleApplication;

use RectorPrefix20210103\Symfony\Component\Console\Application;
use RectorPrefix20210103\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20210103\Symplify\SymplifyKernel\Tests\HttpKernel\PackageBuilderTestingKernel;
final class AutowiredConsoleApplicationTest extends \RectorPrefix20210103\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    protected function setUp() : void
    {
        $this->bootKernel(\RectorPrefix20210103\Symplify\SymplifyKernel\Tests\HttpKernel\PackageBuilderTestingKernel::class);
    }
    public function test() : void
    {
        $application = $this->getService(\RectorPrefix20210103\Symfony\Component\Console\Application::class);
        $this->assertInstanceOf(\RectorPrefix20210103\Symfony\Component\Console\Application::class, $application);
    }
}
