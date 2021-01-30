<?php

declare (strict_types=1);
namespace RectorPrefix20210130\Symplify\SymplifyKernel\Console;

use RectorPrefix20210130\Nette\Utils\Strings;
use RectorPrefix20210130\Symfony\Component\Console\Application;
use RectorPrefix20210130\Symfony\Component\Console\Command\Command;
use RectorPrefix20210130\Symfony\Component\Console\Descriptor\TextDescriptor;
use RectorPrefix20210130\Symfony\Component\Console\Exception\RuntimeException;
use RectorPrefix20210130\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20210130\Symfony\Component\Console\Output\OutputInterface;
use RectorPrefix20210130\Symplify\PackageBuilder\Console\Command\CommandNaming;
use RectorPrefix20210130\Symplify\PackageBuilder\Console\ShellCode;
abstract class AbstractSymplifyConsoleApplication extends \RectorPrefix20210130\Symfony\Component\Console\Application
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
        $this->commandNaming = new \RectorPrefix20210130\Symplify\PackageBuilder\Console\Command\CommandNaming();
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
    protected function doRunCommand(\RectorPrefix20210130\Symfony\Component\Console\Command\Command $command, \RectorPrefix20210130\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20210130\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        return $this->doRunCommandAndShowHelpOnArgumentError($command, $input, $output);
    }
    protected function doRunCommandAndShowHelpOnArgumentError(\RectorPrefix20210130\Symfony\Component\Console\Command\Command $command, \RectorPrefix20210130\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20210130\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        try {
            return parent::doRunCommand($command, $input, $output);
        } catch (\RectorPrefix20210130\Symfony\Component\Console\Exception\RuntimeException $runtimeException) {
            if (\RectorPrefix20210130\Nette\Utils\Strings::contains($runtimeException->getMessage(), 'Provide required arguments')) {
                $this->cleanExtraCommandArgument($command);
                $textDescriptor = new \RectorPrefix20210130\Symfony\Component\Console\Descriptor\TextDescriptor();
                $textDescriptor->describe($output, $command);
                return \RectorPrefix20210130\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
            }
            throw $runtimeException;
        }
    }
    /**
     * Sometimes there is "command" argument,
     * not really needed on fail of missing argument
     */
    private function cleanExtraCommandArgument(\RectorPrefix20210130\Symfony\Component\Console\Command\Command $command) : void
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
