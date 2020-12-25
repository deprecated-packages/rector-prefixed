<?php

declare (strict_types=1);
namespace Rector\Core\Console\Style;

use _PhpScoperbf340cb0be9d\Symfony\Component\Console\Application;
use _PhpScoperbf340cb0be9d\Symfony\Component\Console\Input\ArgvInput;
use _PhpScoperbf340cb0be9d\Symfony\Component\Console\Output\ConsoleOutput;
use _PhpScoperbf340cb0be9d\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoperbf340cb0be9d\Symfony\Component\Console\Style\SymfonyStyle;
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
    public function create() : \_PhpScoperbf340cb0be9d\Symfony\Component\Console\Style\SymfonyStyle
    {
        $argvInput = new \_PhpScoperbf340cb0be9d\Symfony\Component\Console\Input\ArgvInput();
        $consoleOutput = new \_PhpScoperbf340cb0be9d\Symfony\Component\Console\Output\ConsoleOutput();
        // to configure all -v, -vv, -vvv options without memory-lock to Application run() arguments
        $this->privatesCaller->callPrivateMethod(new \_PhpScoperbf340cb0be9d\Symfony\Component\Console\Application(), 'configureIO', $argvInput, $consoleOutput);
        $debugArgvInputParameterOption = $argvInput->getParameterOption('--debug');
        // --debug is called
        if ($debugArgvInputParameterOption === null) {
            $consoleOutput->setVerbosity(\_PhpScoperbf340cb0be9d\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG);
        }
        return new \_PhpScoperbf340cb0be9d\Symfony\Component\Console\Style\SymfonyStyle($argvInput, $consoleOutput);
    }
}
