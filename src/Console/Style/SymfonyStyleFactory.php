<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Console\Style;

use _PhpScopere8e811afab72\Symfony\Component\Console\Application;
use _PhpScopere8e811afab72\Symfony\Component\Console\Input\ArgvInput;
use _PhpScopere8e811afab72\Symfony\Component\Console\Output\ConsoleOutput;
use _PhpScopere8e811afab72\Symfony\Component\Console\Output\OutputInterface;
use _PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesCaller;
final class SymfonyStyleFactory
{
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    public function __construct(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesCaller $privatesCaller)
    {
        $this->privatesCaller = $privatesCaller;
    }
    public function create() : \_PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle
    {
        $argvInput = new \_PhpScopere8e811afab72\Symfony\Component\Console\Input\ArgvInput();
        $consoleOutput = new \_PhpScopere8e811afab72\Symfony\Component\Console\Output\ConsoleOutput();
        // to configure all -v, -vv, -vvv options without memory-lock to Application run() arguments
        $this->privatesCaller->callPrivateMethod(new \_PhpScopere8e811afab72\Symfony\Component\Console\Application(), 'configureIO', $argvInput, $consoleOutput);
        $debugArgvInputParameterOption = $argvInput->getParameterOption('--debug');
        // --debug is called
        if ($debugArgvInputParameterOption === null) {
            $consoleOutput->setVerbosity(\_PhpScopere8e811afab72\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG);
        }
        return new \_PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle($argvInput, $consoleOutput);
    }
}
