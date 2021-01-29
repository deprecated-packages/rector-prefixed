<?php

declare (strict_types=1);
namespace Rector\Core\Console;

use RectorPrefix20210129\Composer\XdebugHandler\XdebugHandler;
use OutOfBoundsException;
use Rector\ChangesReporting\Output\CheckstyleOutputFormatter;
use Rector\ChangesReporting\Output\JsonOutputFormatter;
use Rector\Core\Bootstrap\NoRectorsLoadedReporter;
use Rector\Core\Configuration\Configuration;
use Rector\Core\Configuration\Option;
use Rector\Core\Exception\Configuration\InvalidConfigurationException;
use Rector\Core\Exception\NoRectorsLoadedException;
use Rector\Utils\NodeDocumentationGenerator\Command\DumpNodesCommand;
use RectorPrefix20210129\Symfony\Component\Console\Application;
use RectorPrefix20210129\Symfony\Component\Console\Command\Command;
use RectorPrefix20210129\Symfony\Component\Console\Input\InputDefinition;
use RectorPrefix20210129\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20210129\Symfony\Component\Console\Input\InputOption;
use RectorPrefix20210129\Symfony\Component\Console\Output\OutputInterface;
use RectorPrefix20210129\Symplify\PackageBuilder\Console\Command\CommandNaming;
use RectorPrefix20210129\Symplify\SmartFileSystem\SmartFileInfo;
use Throwable;
final class ConsoleApplication extends \RectorPrefix20210129\Symfony\Component\Console\Application
{
    /**
     * @var string
     */
    private const NAME = 'Rector';
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var NoRectorsLoadedReporter
     */
    private $noRectorsLoadedReporter;
    /**
     * @param Command[] $commands
     */
    public function __construct(\Rector\Core\Configuration\Configuration $configuration, \Rector\Core\Bootstrap\NoRectorsLoadedReporter $noRectorsLoadedReporter, \RectorPrefix20210129\Symplify\PackageBuilder\Console\Command\CommandNaming $commandNaming, array $commands = [])
    {
        try {
            $version = $configuration->getPrettyVersion();
        } catch (\OutOfBoundsException $outOfBoundsException) {
            $version = 'Unknown';
        }
        parent::__construct(self::NAME, $version);
        foreach ($commands as $command) {
            $commandName = $commandNaming->resolveFromCommand($command);
            $command->setName($commandName);
        }
        $this->addCommands($commands);
        $this->configuration = $configuration;
        $this->noRectorsLoadedReporter = $noRectorsLoadedReporter;
    }
    public function doRun(\RectorPrefix20210129\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20210129\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        // @fixes https://github.com/rectorphp/rector/issues/2205
        $isXdebugAllowed = $input->hasParameterOption('--xdebug');
        if (!$isXdebugAllowed) {
            $xdebugHandler = new \RectorPrefix20210129\Composer\XdebugHandler\XdebugHandler('rector', '--ansi');
            $xdebugHandler->check();
            unset($xdebugHandler);
        }
        $shouldFollowByNewline = \false;
        // switch working dir
        $newWorkDir = $this->getNewWorkingDir($input);
        if ($newWorkDir !== '') {
            $oldWorkingDir = \getcwd();
            \chdir($newWorkDir);
            $output->isDebug() && $output->writeln('Changed CWD form ' . $oldWorkingDir . ' to ' . \getcwd());
        }
        // skip in this case, since generate content must be clear from meta-info
        $dumpCommands = [\RectorPrefix20210129\Symplify\PackageBuilder\Console\Command\CommandNaming::classToName(\Rector\Utils\NodeDocumentationGenerator\Command\DumpNodesCommand::class)];
        if (\in_array($input->getFirstArgument(), $dumpCommands, \true)) {
            return parent::doRun($input, $output);
        }
        if ($this->shouldPrintMetaInformation($input)) {
            $output->writeln($this->getLongVersion());
            $shouldFollowByNewline = \true;
            $configFilePath = $this->configuration->getConfigFilePath();
            if ($configFilePath) {
                $configFileInfo = new \RectorPrefix20210129\Symplify\SmartFileSystem\SmartFileInfo($configFilePath);
                $relativeConfigPath = $configFileInfo->getRelativeFilePathFromDirectory(\getcwd());
                $output->writeln('Config file: ' . $relativeConfigPath);
                $shouldFollowByNewline = \true;
            }
        }
        if ($shouldFollowByNewline) {
            $output->write(\PHP_EOL);
        }
        return parent::doRun($input, $output);
    }
    public function renderThrowable(\Throwable $throwable, \RectorPrefix20210129\Symfony\Component\Console\Output\OutputInterface $output) : void
    {
        if (\is_a($throwable, \Rector\Core\Exception\NoRectorsLoadedException::class)) {
            $this->noRectorsLoadedReporter->report();
            return;
        }
        parent::renderThrowable($throwable, $output);
    }
    protected function getDefaultInputDefinition() : \RectorPrefix20210129\Symfony\Component\Console\Input\InputDefinition
    {
        $defaultInputDefinition = parent::getDefaultInputDefinition();
        $this->removeUnusedOptions($defaultInputDefinition);
        $this->addCustomOptions($defaultInputDefinition);
        return $defaultInputDefinition;
    }
    private function getNewWorkingDir(\RectorPrefix20210129\Symfony\Component\Console\Input\InputInterface $input) : string
    {
        $workingDir = $input->getParameterOption('--working-dir');
        if ($workingDir !== \false && !\is_dir($workingDir)) {
            $errorMessage = \sprintf('Invalid working directory specified, "%s" does not exist.', $workingDir);
            throw new \Rector\Core\Exception\Configuration\InvalidConfigurationException($errorMessage);
        }
        return (string) $workingDir;
    }
    private function shouldPrintMetaInformation(\RectorPrefix20210129\Symfony\Component\Console\Input\InputInterface $input) : bool
    {
        $hasNoArguments = $input->getFirstArgument() === null;
        if ($hasNoArguments) {
            return \false;
        }
        $hasVersionOption = $input->hasParameterOption('--version');
        if ($hasVersionOption) {
            return \false;
        }
        $outputFormat = $input->getParameterOption(['-o', '--output-format']);
        return !\in_array($outputFormat, [\Rector\ChangesReporting\Output\JsonOutputFormatter::NAME, \Rector\ChangesReporting\Output\CheckstyleOutputFormatter::NAME], \true);
    }
    private function removeUnusedOptions(\RectorPrefix20210129\Symfony\Component\Console\Input\InputDefinition $inputDefinition) : void
    {
        $options = $inputDefinition->getOptions();
        unset($options['quiet'], $options['no-interaction']);
        $inputDefinition->setOptions($options);
    }
    private function addCustomOptions(\RectorPrefix20210129\Symfony\Component\Console\Input\InputDefinition $inputDefinition) : void
    {
        $inputDefinition->addOption(new \RectorPrefix20210129\Symfony\Component\Console\Input\InputOption(\Rector\Core\Configuration\Option::OPTION_CONFIG, 'c', \RectorPrefix20210129\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to config file', $this->getDefaultConfigPath()));
        $inputDefinition->addOption(new \RectorPrefix20210129\Symfony\Component\Console\Input\InputOption(\Rector\Core\Configuration\Option::OPTION_DEBUG, null, \RectorPrefix20210129\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Enable debug verbosity (-vvv)'));
        $inputDefinition->addOption(new \RectorPrefix20210129\Symfony\Component\Console\Input\InputOption(\Rector\Core\Configuration\Option::XDEBUG, null, \RectorPrefix20210129\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Allow running xdebug'));
        $inputDefinition->addOption(new \RectorPrefix20210129\Symfony\Component\Console\Input\InputOption(\Rector\Core\Configuration\Option::OPTION_CLEAR_CACHE, null, \RectorPrefix20210129\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Clear cache'));
        $inputDefinition->addOption(new \RectorPrefix20210129\Symfony\Component\Console\Input\InputOption('working-dir', null, \RectorPrefix20210129\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'If specified, use the given directory as working directory.'));
    }
    private function getDefaultConfigPath() : string
    {
        return \getcwd() . '/rector.php';
    }
}
