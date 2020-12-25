<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Console\Style;

use _PhpScoper8b9c402c5f32\Symfony\Component\Console\Application;
use _PhpScoper8b9c402c5f32\Symfony\Component\Console\Input\ArgvInput;
use _PhpScoper8b9c402c5f32\Symfony\Component\Console\Output\ConsoleOutput;
use _PhpScoper8b9c402c5f32\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoper8b9c402c5f32\Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\EasyTesting\PHPUnit\StaticPHPUnitEnvironment;
use Symplify\PackageBuilder\Reflection\PrivatesCaller;
final class SymfonyStyleFactory
{
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    public function __construct()
    {
        $this->privatesCaller = new \Symplify\PackageBuilder\Reflection\PrivatesCaller();
    }
    public function create() : \_PhpScoper8b9c402c5f32\Symfony\Component\Console\Style\SymfonyStyle
    {
        // to prevent missing argv indexes
        if (!isset($_SERVER['argv'])) {
            $_SERVER['argv'] = [];
        }
        $argvInput = new \_PhpScoper8b9c402c5f32\Symfony\Component\Console\Input\ArgvInput();
        $consoleOutput = new \_PhpScoper8b9c402c5f32\Symfony\Component\Console\Output\ConsoleOutput();
        // to configure all -v, -vv, -vvv options without memory-lock to Application run() arguments
        $this->privatesCaller->callPrivateMethod(new \_PhpScoper8b9c402c5f32\Symfony\Component\Console\Application(), 'configureIO', $argvInput, $consoleOutput);
        // --debug is called
        if ($argvInput->hasParameterOption('--debug')) {
            $consoleOutput->setVerbosity(\_PhpScoper8b9c402c5f32\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG);
        }
        // disable output for tests
        if (\Symplify\EasyTesting\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            $consoleOutput->setVerbosity(\_PhpScoper8b9c402c5f32\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET);
        }
        return new \_PhpScoper8b9c402c5f32\Symfony\Component\Console\Style\SymfonyStyle($argvInput, $consoleOutput);
    }
}
