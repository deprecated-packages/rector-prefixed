<?php

declare (strict_types=1);
namespace Rector\Core\Console;

use _PhpScoper5b8c9e9ebd21\Composer\XdebugHandler\XdebugHandler;
use OutOfBoundsException;
use Rector\ChangesReporting\Output\CheckstyleOutputFormatter;
use Rector\ChangesReporting\Output\JsonOutputFormatter;
use Rector\Core\Bootstrap\NoRectorsLoadedReporter;
use Rector\Core\Configuration\Configuration;
use Rector\Core\Configuration\Option;
use Rector\Core\Exception\Configuration\InvalidConfigurationException;
use Rector\Core\Exception\NoRectorsLoadedException;
use Rector\Utils\NodeDocumentationGenerator\Command\DumpNodesCommand;
use _PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Application;
use _PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Command\Command;
use _PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputDefinition;
use _PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputOption;
use _PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Output\OutputInterface;
use Symplify\PackageBuilder\Console\Command\CommandNaming;
use Symplify\SmartFileSystem\SmartFileInfo;
use Throwable;
final class ConsoleApplication extends \_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Application
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
    public function __construct(\Rector\Core\Configuration\Configuration $configuration, \Rector\Core\Bootstrap\NoRectorsLoadedReporter $noRectorsLoadedReporter, \Symplify\PackageBuilder\Console\Command\CommandNaming $commandNaming, array $commands = [])
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
    public function doRun(\_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        // @fixes https://github.com/rectorphp/rector/issues/2205
        $isXdebugAllowed = $input->hasParameterOption('--xdebug');
        if (!$isXdebugAllowed) {
            $xdebugHandler = new \_PhpScoper5b8c9e9ebd21\Composer\XdebugHandler\XdebugHandler('rector', '--ansi');
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
        $dumpCommands = [\Symplify\PackageBuilder\Console\Command\CommandNaming::classToName(\Rector\Utils\NodeDocumentationGenerator\Command\DumpNodesCommand::class)];
        if (\in_array($input->getFirstArgument(), $dumpCommands, \true)) {
            return parent::doRun($input, $output);
        }
        if ($this->shouldPrintMetaInformation($input)) {
            $output->writeln($this->getLongVersion());
            $shouldFollowByNewline = \true;
            $configFilePath = $this->configuration->getConfigFilePath();
            if ($configFilePath) {
                $configFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo($configFilePath);
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
    public function renderThrowable(\Throwable $throwable, \_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Output\OutputInterface $output) : void
    {
        if (\is_a($throwable, \Rector\Core\Exception\NoRectorsLoadedException::class)) {
            $this->noRectorsLoadedReporter->report();
            return;
        }
        parent::renderThrowable($throwable, $output);
    }
    protected function getDefaultInputDefinition() : \_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputDefinition
    {
        $defaultInputDefinition = parent::getDefaultInputDefinition();
        $this->removeUnusedOptions($defaultInputDefinition);
        $this->addCustomOptions($defaultInputDefinition);
        return $defaultInputDefinition;
    }
    private function getNewWorkingDir(\_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputInterface $input) : string
    {
        $workingDir = $input->getParameterOption(['--working-dir', '-d']);
        if ($workingDir !== \false && !\is_dir($workingDir)) {
            throw new \Rector\Core\Exception\Configuration\InvalidConfigurationException('Invalid working directory specified, ' . $workingDir . ' does not exist.');
        }
        return (string) $workingDir;
    }
    private function shouldPrintMetaInformation(\_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputInterface $input) : bool
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
    private function removeUnusedOptions(\_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputDefinition $inputDefinition) : void
    {
        $options = $inputDefinition->getOptions();
        unset($options['quiet'], $options['no-interaction']);
        $inputDefinition->setOptions($options);
    }
    private function addCustomOptions(\_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputDefinition $inputDefinition) : void
    {
        $inputDefinition->addOption(new \_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputOption(\Rector\Core\Configuration\Option::OPTION_CONFIG, 'c', \_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to config file', $this->getDefaultConfigPath()));
        $inputDefinition->addOption(new \_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputOption(\Rector\Core\Configuration\Option::OPTION_DEBUG, null, \_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Enable debug verbosity (-vvv)'));
        $inputDefinition->addOption(new \_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputOption(\Rector\Core\Configuration\Option::XDEBUG, null, \_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Allow running xdebug'));
        $inputDefinition->addOption(new \_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputOption(\Rector\Core\Configuration\Option::OPTION_CLEAR_CACHE, null, \_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Clear cache'));
        $inputDefinition->addOption(new \_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputOption('--working-dir', '-d', \_PhpScoper5b8c9e9ebd21\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'If specified, use the given directory as working directory.'));
    }
    private function getDefaultConfigPath() : string
    {
        return \getcwd() . '/rector.php';
    }
}
