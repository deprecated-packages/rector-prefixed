<?php

declare (strict_types=1);
namespace RectorPrefix20210320\Symplify\ConsolePackageBuilder\Tests\DependencyInjection\CompilerPass;

use RectorPrefix20210320\Symfony\Component\Console\Application;
use RectorPrefix20210320\Symplify\ConsolePackageBuilder\Tests\DependencyInjection\CompilerPass\Source\SomeCommand;
use RectorPrefix20210320\Symplify\ConsolePackageBuilder\Tests\HttpKernel\ConsolePackageBuilderKernel;
use RectorPrefix20210320\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class NamelessConsoleCommandCompilerPassTest extends \RectorPrefix20210320\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    protected function setUp() : void
    {
        $this->bootKernelWithConfigs(\RectorPrefix20210320\Symplify\ConsolePackageBuilder\Tests\HttpKernel\ConsolePackageBuilderKernel::class, [__DIR__ . '/config/command_config.php']);
    }
    public function test() : void
    {
        /** @var Application $application */
        $application = $this->getService(\RectorPrefix20210320\Symfony\Component\Console\Application::class);
        $this->assertInstanceOf(\RectorPrefix20210320\Symfony\Component\Console\Application::class, $application);
        $someCommand = $application->get('some');
        $this->assertInstanceOf(\RectorPrefix20210320\Symplify\ConsolePackageBuilder\Tests\DependencyInjection\CompilerPass\Source\SomeCommand::class, $someCommand);
    }
}
