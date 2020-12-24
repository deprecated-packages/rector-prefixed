<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\Style;

use _PhpScoper0a6b37af0871\Symfony\Component\Console\Application;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Input\ArgvInput;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Output\ConsoleOutput;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper0a6b37af0871\Symplify\EasyTesting\PHPUnit\StaticPHPUnitEnvironment;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesCaller;
final class SymfonyStyleFactory
{
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    public function __construct()
    {
        $this->privatesCaller = new \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesCaller();
    }
    public function create() : \_PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle
    {
        // to prevent missing argv indexes
        if (!isset($_SERVER['argv'])) {
            $_SERVER['argv'] = [];
        }
        $argvInput = new \_PhpScoper0a6b37af0871\Symfony\Component\Console\Input\ArgvInput();
        $consoleOutput = new \_PhpScoper0a6b37af0871\Symfony\Component\Console\Output\ConsoleOutput();
        // to configure all -v, -vv, -vvv options without memory-lock to Application run() arguments
        $this->privatesCaller->callPrivateMethod(new \_PhpScoper0a6b37af0871\Symfony\Component\Console\Application(), 'configureIO', $argvInput, $consoleOutput);
        // --debug is called
        if ($argvInput->hasParameterOption('--debug')) {
            $consoleOutput->setVerbosity(\_PhpScoper0a6b37af0871\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG);
        }
        // disable output for tests
        if (\_PhpScoper0a6b37af0871\Symplify\EasyTesting\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            $consoleOutput->setVerbosity(\_PhpScoper0a6b37af0871\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET);
        }
        return new \_PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle($argvInput, $consoleOutput);
    }
}
