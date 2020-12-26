<?php

declare (strict_types=1);
namespace Symplify\SymplifyKernel\Console;

use RectorPrefix2020DecSat\Nette\Utils\Strings;
use RectorPrefix2020DecSat\Symfony\Component\Console\Application;
use RectorPrefix2020DecSat\Symfony\Component\Console\Command\Command;
use RectorPrefix2020DecSat\Symfony\Component\Console\Descriptor\TextDescriptor;
use RectorPrefix2020DecSat\Symfony\Component\Console\Exception\RuntimeException;
use RectorPrefix2020DecSat\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix2020DecSat\Symfony\Component\Console\Output\OutputInterface;
use Symplify\PackageBuilder\Console\Command\CommandNaming;
use Symplify\PackageBuilder\Console\ShellCode;
abstract class AbstractSymplifyConsoleApplication extends \RectorPrefix2020DecSat\Symfony\Component\Console\Application
{
    /**
     * @var string
     */
    private const COMMAND = 'command';
    /**
     * @var CommandNaming
     */
    private $commandNaming;
    /**
     * @param Command[] $commands
     */
    public function __construct(array $commands, string $name = 'UNKNOWN', string $version = 'UNKNOWN')
    {
        $this->commandNaming = new \Symplify\PackageBuilder\Console\Command\CommandNaming();
        $this->addCommands($commands);
        parent::__construct($name, $version);
    }
    /**
     * Add names to all commands by class-name convention
     * @param Command[] $commands
     */
    public function addCommands(array $commands) : void
    {
        foreach ($commands as $command) {
            $commandName = $this->commandNaming->resolveFromCommand($command);
            $command->setName($commandName);
        }
        parent::addCommands($commands);
    }
    protected function doRunCommand(\RectorPrefix2020DecSat\Symfony\Component\Console\Command\Command $command, \RectorPrefix2020DecSat\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix2020DecSat\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        return $this->doRunCommandAndShowHelpOnArgumentError($command, $input, $output);
    }
    protected function doRunCommandAndShowHelpOnArgumentError(\RectorPrefix2020DecSat\Symfony\Component\Console\Command\Command $command, \RectorPrefix2020DecSat\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix2020DecSat\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        try {
            return parent::doRunCommand($command, $input, $output);
        } catch (\RectorPrefix2020DecSat\Symfony\Component\Console\Exception\RuntimeException $runtimeException) {
            if (\RectorPrefix2020DecSat\Nette\Utils\Strings::contains($runtimeException->getMessage(), 'Provide required arguments')) {
                $this->cleanExtraCommandArgument($command);
                $textDescriptor = new \RectorPrefix2020DecSat\Symfony\Component\Console\Descriptor\TextDescriptor();
                $textDescriptor->describe($output, $command);
                return \Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
            }
            throw $runtimeException;
        }
    }
    /**
     * Sometimes there is "command" argument,
     * not really needed on fail of missing argument
     */
    private function cleanExtraCommandArgument(\RectorPrefix2020DecSat\Symfony\Component\Console\Command\Command $command) : void
    {
        $inputDefinition = $command->getDefinition();
        $arguments = $inputDefinition->getArguments();
        if (!isset($arguments[self::COMMAND])) {
            return;
        }
        unset($arguments[self::COMMAND]);
        $inputDefinition->setArguments($arguments);
    }
}
