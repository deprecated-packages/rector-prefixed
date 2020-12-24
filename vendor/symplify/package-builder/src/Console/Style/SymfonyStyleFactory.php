<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Console\Style;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Application;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\ArgvInput;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Output\ConsoleOutput;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper2a4e7ab1ecbc\Symplify\EasyTesting\PHPUnit\StaticPHPUnitEnvironment;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Reflection\PrivatesCaller;
final class SymfonyStyleFactory
{
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    public function __construct()
    {
        $this->privatesCaller = new \_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Reflection\PrivatesCaller();
    }
    public function create() : \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Style\SymfonyStyle
    {
        // to prevent missing argv indexes
        if (!isset($_SERVER['argv'])) {
            $_SERVER['argv'] = [];
        }
        $argvInput = new \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\ArgvInput();
        $consoleOutput = new \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Output\ConsoleOutput();
        // to configure all -v, -vv, -vvv options without memory-lock to Application run() arguments
        $this->privatesCaller->callPrivateMethod(new \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Application(), 'configureIO', $argvInput, $consoleOutput);
        // --debug is called
        if ($argvInput->hasParameterOption('--debug')) {
            $consoleOutput->setVerbosity(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG);
        }
        // disable output for tests
        if (\_PhpScoper2a4e7ab1ecbc\Symplify\EasyTesting\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            $consoleOutput->setVerbosity(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET);
        }
        return new \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Style\SymfonyStyle($argvInput, $consoleOutput);
    }
}
