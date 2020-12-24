<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Console\Style;

use _PhpScoperb75b35f52b74\Symfony\Component\Console\Application;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Input\ArgvInput;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Output\ConsoleOutput;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesCaller;
final class SymfonyStyleFactory
{
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesCaller $privatesCaller)
    {
        $this->privatesCaller = $privatesCaller;
    }
    public function create() : \_PhpScoperb75b35f52b74\Symfony\Component\Console\Style\SymfonyStyle
    {
        $argvInput = new \_PhpScoperb75b35f52b74\Symfony\Component\Console\Input\ArgvInput();
        $consoleOutput = new \_PhpScoperb75b35f52b74\Symfony\Component\Console\Output\ConsoleOutput();
        // to configure all -v, -vv, -vvv options without memory-lock to Application run() arguments
        $this->privatesCaller->callPrivateMethod(new \_PhpScoperb75b35f52b74\Symfony\Component\Console\Application(), 'configureIO', $argvInput, $consoleOutput);
        $debugArgvInputParameterOption = $argvInput->getParameterOption('--debug');
        // --debug is called
        if ($debugArgvInputParameterOption === null) {
            $consoleOutput->setVerbosity(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG);
        }
        return new \_PhpScoperb75b35f52b74\Symfony\Component\Console\Style\SymfonyStyle($argvInput, $consoleOutput);
    }
}
