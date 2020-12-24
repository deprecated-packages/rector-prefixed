<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Style;

use _PhpScopere8e811afab72\Symfony\Component\Console\Application;
use _PhpScopere8e811afab72\Symfony\Component\Console\Input\ArgvInput;
use _PhpScopere8e811afab72\Symfony\Component\Console\Output\ConsoleOutput;
use _PhpScopere8e811afab72\Symfony\Component\Console\Output\OutputInterface;
use _PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScopere8e811afab72\Symplify\EasyTesting\PHPUnit\StaticPHPUnitEnvironment;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesCaller;
final class SymfonyStyleFactory
{
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    public function __construct()
    {
        $this->privatesCaller = new \_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesCaller();
    }
    public function create() : \_PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle
    {
        // to prevent missing argv indexes
        if (!isset($_SERVER['argv'])) {
            $_SERVER['argv'] = [];
        }
        $argvInput = new \_PhpScopere8e811afab72\Symfony\Component\Console\Input\ArgvInput();
        $consoleOutput = new \_PhpScopere8e811afab72\Symfony\Component\Console\Output\ConsoleOutput();
        // to configure all -v, -vv, -vvv options without memory-lock to Application run() arguments
        $this->privatesCaller->callPrivateMethod(new \_PhpScopere8e811afab72\Symfony\Component\Console\Application(), 'configureIO', $argvInput, $consoleOutput);
        // --debug is called
        if ($argvInput->hasParameterOption('--debug')) {
            $consoleOutput->setVerbosity(\_PhpScopere8e811afab72\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG);
        }
        // disable output for tests
        if (\_PhpScopere8e811afab72\Symplify\EasyTesting\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            $consoleOutput->setVerbosity(\_PhpScopere8e811afab72\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET);
        }
        return new \_PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle($argvInput, $consoleOutput);
    }
}
