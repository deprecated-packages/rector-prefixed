<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Console\Style;

use RectorPrefix2020DecSat\Symfony\Component\Console\Application;
use RectorPrefix2020DecSat\Symfony\Component\Console\Input\ArgvInput;
use RectorPrefix2020DecSat\Symfony\Component\Console\Output\ConsoleOutput;
use RectorPrefix2020DecSat\Symfony\Component\Console\Output\OutputInterface;
use RectorPrefix2020DecSat\Symfony\Component\Console\Style\SymfonyStyle;
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
    public function create() : \RectorPrefix2020DecSat\Symfony\Component\Console\Style\SymfonyStyle
    {
        // to prevent missing argv indexes
        if (!isset($_SERVER['argv'])) {
            $_SERVER['argv'] = [];
        }
        $argvInput = new \RectorPrefix2020DecSat\Symfony\Component\Console\Input\ArgvInput();
        $consoleOutput = new \RectorPrefix2020DecSat\Symfony\Component\Console\Output\ConsoleOutput();
        // to configure all -v, -vv, -vvv options without memory-lock to Application run() arguments
        $this->privatesCaller->callPrivateMethod(new \RectorPrefix2020DecSat\Symfony\Component\Console\Application(), 'configureIO', $argvInput, $consoleOutput);
        // --debug is called
        if ($argvInput->hasParameterOption('--debug')) {
            $consoleOutput->setVerbosity(\RectorPrefix2020DecSat\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG);
        }
        // disable output for tests
        if (\Symplify\EasyTesting\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            $consoleOutput->setVerbosity(\RectorPrefix2020DecSat\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET);
        }
        return new \RectorPrefix2020DecSat\Symfony\Component\Console\Style\SymfonyStyle($argvInput, $consoleOutput);
    }
}
