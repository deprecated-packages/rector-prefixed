<?php

declare (strict_types=1);
namespace Rector\Core\Console\Style;

use RectorPrefix2020DecSat\Symfony\Component\Console\Application;
use RectorPrefix2020DecSat\Symfony\Component\Console\Input\ArgvInput;
use RectorPrefix2020DecSat\Symfony\Component\Console\Output\ConsoleOutput;
use RectorPrefix2020DecSat\Symfony\Component\Console\Output\OutputInterface;
use RectorPrefix2020DecSat\Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\PackageBuilder\Reflection\PrivatesCaller;
final class SymfonyStyleFactory
{
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    public function __construct(\Symplify\PackageBuilder\Reflection\PrivatesCaller $privatesCaller)
    {
        $this->privatesCaller = $privatesCaller;
    }
    public function create() : \RectorPrefix2020DecSat\Symfony\Component\Console\Style\SymfonyStyle
    {
        $argvInput = new \RectorPrefix2020DecSat\Symfony\Component\Console\Input\ArgvInput();
        $consoleOutput = new \RectorPrefix2020DecSat\Symfony\Component\Console\Output\ConsoleOutput();
        // to configure all -v, -vv, -vvv options without memory-lock to Application run() arguments
        $this->privatesCaller->callPrivateMethod(new \RectorPrefix2020DecSat\Symfony\Component\Console\Application(), 'configureIO', $argvInput, $consoleOutput);
        $debugArgvInputParameterOption = $argvInput->getParameterOption('--debug');
        // --debug is called
        if ($debugArgvInputParameterOption === null) {
            $consoleOutput->setVerbosity(\RectorPrefix2020DecSat\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG);
        }
        return new \RectorPrefix2020DecSat\Symfony\Component\Console\Style\SymfonyStyle($argvInput, $consoleOutput);
    }
}
