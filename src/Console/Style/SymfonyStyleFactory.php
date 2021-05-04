<?php

declare (strict_types=1);
namespace Rector\Core\Console\Style;

use RectorPrefix20210504\Symfony\Component\Console\Application;
use RectorPrefix20210504\Symfony\Component\Console\Input\ArgvInput;
use RectorPrefix20210504\Symfony\Component\Console\Output\ConsoleOutput;
use RectorPrefix20210504\Symfony\Component\Console\Output\OutputInterface;
use RectorPrefix20210504\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20210504\Symplify\PackageBuilder\Reflection\PrivatesCaller;
final class SymfonyStyleFactory
{
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    public function __construct(\RectorPrefix20210504\Symplify\PackageBuilder\Reflection\PrivatesCaller $privatesCaller)
    {
        $this->privatesCaller = $privatesCaller;
    }
    public function create() : \RectorPrefix20210504\Symfony\Component\Console\Style\SymfonyStyle
    {
        $argvInput = new \RectorPrefix20210504\Symfony\Component\Console\Input\ArgvInput();
        $consoleOutput = new \RectorPrefix20210504\Symfony\Component\Console\Output\ConsoleOutput();
        // to configure all -v, -vv, -vvv options without memory-lock to Application run() arguments
        $this->privatesCaller->callPrivateMethod(new \RectorPrefix20210504\Symfony\Component\Console\Application(), 'configureIO', [$argvInput, $consoleOutput]);
        $debugArgvInputParameterOption = $argvInput->getParameterOption('--debug');
        // --debug is called
        if ($debugArgvInputParameterOption === null) {
            $consoleOutput->setVerbosity(\RectorPrefix20210504\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG);
        }
        return new \RectorPrefix20210504\Symfony\Component\Console\Style\SymfonyStyle($argvInput, $consoleOutput);
    }
}
