<?php

declare (strict_types=1);
namespace RectorPrefix20210308\Symplify\SymplifyKernel\Tests\Console\AbstractSymplifyConsoleApplication;

use RectorPrefix20210308\Symfony\Component\Console\Application;
use RectorPrefix20210308\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20210308\Symplify\SymplifyKernel\Tests\HttpKernel\OnlyForTestsKernel;
final class AutowiredConsoleApplicationTest extends \RectorPrefix20210308\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    protected function setUp() : void
    {
        $this->bootKernel(\RectorPrefix20210308\Symplify\SymplifyKernel\Tests\HttpKernel\OnlyForTestsKernel::class);
    }
    public function test() : void
    {
        $application = $this->getService(\RectorPrefix20210308\Symfony\Component\Console\Application::class);
        $this->assertInstanceOf(\RectorPrefix20210308\Symfony\Component\Console\Application::class, $application);
    }
}
