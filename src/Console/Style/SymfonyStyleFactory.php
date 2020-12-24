<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\Console\Style;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Application;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\ArgvInput;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Output\ConsoleOutput;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Reflection\PrivatesCaller;
final class SymfonyStyleFactory
{
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Reflection\PrivatesCaller $privatesCaller)
    {
        $this->privatesCaller = $privatesCaller;
    }
    public function create() : \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Style\SymfonyStyle
    {
        $argvInput = new \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\ArgvInput();
        $consoleOutput = new \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Output\ConsoleOutput();
        // to configure all -v, -vv, -vvv options without memory-lock to Application run() arguments
        $this->privatesCaller->callPrivateMethod(new \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Application(), 'configureIO', $argvInput, $consoleOutput);
        $debugArgvInputParameterOption = $argvInput->getParameterOption('--debug');
        // --debug is called
        if ($debugArgvInputParameterOption === null) {
            $consoleOutput->setVerbosity(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG);
        }
        return new \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Style\SymfonyStyle($argvInput, $consoleOutput);
    }
}
