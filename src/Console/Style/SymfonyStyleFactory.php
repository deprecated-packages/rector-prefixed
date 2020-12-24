<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Console\Style;

use _PhpScoper0a6b37af0871\Symfony\Component\Console\Application;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Input\ArgvInput;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Output\ConsoleOutput;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesCaller;
final class SymfonyStyleFactory
{
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesCaller $privatesCaller)
    {
        $this->privatesCaller = $privatesCaller;
    }
    public function create() : \_PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle
    {
        $argvInput = new \_PhpScoper0a6b37af0871\Symfony\Component\Console\Input\ArgvInput();
        $consoleOutput = new \_PhpScoper0a6b37af0871\Symfony\Component\Console\Output\ConsoleOutput();
        // to configure all -v, -vv, -vvv options without memory-lock to Application run() arguments
        $this->privatesCaller->callPrivateMethod(new \_PhpScoper0a6b37af0871\Symfony\Component\Console\Application(), 'configureIO', $argvInput, $consoleOutput);
        $debugArgvInputParameterOption = $argvInput->getParameterOption('--debug');
        // --debug is called
        if ($debugArgvInputParameterOption === null) {
            $consoleOutput->setVerbosity(\_PhpScoper0a6b37af0871\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG);
        }
        return new \_PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle($argvInput, $consoleOutput);
    }
}
