<?php

declare (strict_types=1);
namespace Rector\Core\Console\Command;

use Rector\Caching\Detector\ChangedFilesDetector;
use Rector\ChangesReporting\Application\ErrorAndDiffCollector;
use Rector\ChangesReporting\Output\ConsoleOutputFormatter;
use Rector\Composer\Processor\ComposerProcessor;
use Rector\Core\Application\RectorApplication;
use Rector\Core\Autoloading\AdditionalAutoloader;
use Rector\Core\Configuration\Configuration;
use Rector\Core\Configuration\Option;
use Rector\Core\Console\Output\OutputFormatterCollector;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\FileSystem\FilesFinder;
use Rector\Core\FileSystem\PhpFilesFinder;
use Rector\Core\Guard\RectorGuard;
use Rector\Core\NonPhpFile\NonPhpFileProcessor;
use Rector\Core\PhpParser\NodeTraverser\RectorNodeTraverser;
use Rector\Core\ValueObject\StaticNonPhpFileSuffixes;
use RectorPrefix20210312\Symfony\Component\Console\Application;
use RectorPrefix20210312\Symfony\Component\Console\Command\Command;
use RectorPrefix20210312\Symfony\Component\Console\Input\InputArgument;
use RectorPrefix20210312\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20210312\Symfony\Component\Console\Input\InputOption;
use RectorPrefix20210312\Symfony\Component\Console\Output\OutputInterface;
use RectorPrefix20210312\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20210312\Symplify\PackageBuilder\Console\ShellCode;
final class ProcessCommand extends \RectorPrefix20210312\Symfony\Component\Console\Command\Command
{
    /**
     * @var FilesFinder
     */
    private $filesFinder;
    /**
     * @var AdditionalAutoloader
     */
    private $additionalAutoloader;
    /**
     * @var RectorGuard
     */
    private $rectorGuard;
    /**
     * @var ErrorAndDiffCollector
     */
    private $errorAndDiffCollector;
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var RectorApplication
     */
    private $rectorApplication;
    /**
     * @var OutputFormatterCollector
     */
    private $outputFormatterCollector;
    /**
     * @var RectorNodeTraverser
     */
    private $rectorNodeTraverser;
    /**
     * @var NonPhpFileProcessor
     */
    private $nonPhpFileProcessor;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var ComposerProcessor
     */
    private $composerProcessor;
    /**
     * @var PhpFilesFinder
     */
    private $phpFilesFinder;
    /**
     * @var ChangedFilesDetector
     */
    private $changedFilesDetector;
    public function __construct(\Rector\Core\Autoloading\AdditionalAutoloader $additionalAutoloader, \Rector\Caching\Detector\ChangedFilesDetector $changedFilesDetector, \Rector\Core\Configuration\Configuration $configuration, \Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector, \Rector\Core\FileSystem\FilesFinder $filesFinder, \Rector\Core\NonPhpFile\NonPhpFileProcessor $nonPhpFileProcessor, \Rector\Core\Console\Output\OutputFormatterCollector $outputFormatterCollector, \Rector\Core\Application\RectorApplication $rectorApplication, \Rector\Core\Guard\RectorGuard $rectorGuard, \Rector\Core\PhpParser\NodeTraverser\RectorNodeTraverser $rectorNodeTraverser, \RectorPrefix20210312\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \Rector\Composer\Processor\ComposerProcessor $composerProcessor, \Rector\Core\FileSystem\PhpFilesFinder $phpFilesFinder)
    {
        $this->filesFinder = $filesFinder;
        $this->additionalAutoloader = $additionalAutoloader;
        $this->rectorGuard = $rectorGuard;
        $this->errorAndDiffCollector = $errorAndDiffCollector;
        $this->configuration = $configuration;
        $this->rectorApplication = $rectorApplication;
        $this->outputFormatterCollector = $outputFormatterCollector;
        $this->rectorNodeTraverser = $rectorNodeTraverser;
        $this->nonPhpFileProcessor = $nonPhpFileProcessor;
        $this->changedFilesDetector = $changedFilesDetector;
        $this->symfonyStyle = $symfonyStyle;
        $this->composerProcessor = $composerProcessor;
        $this->phpFilesFinder = $phpFilesFinder;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setDescription('Upgrade or refactor source code with provided rectors');
        $this->addArgument(\Rector\Core\Configuration\Option::SOURCE, \RectorPrefix20210312\Symfony\Component\Console\Input\InputArgument::OPTIONAL | \RectorPrefix20210312\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Files or directories to be upgraded.');
        $this->addOption(\Rector\Core\Configuration\Option::OPTION_DRY_RUN, 'n', \RectorPrefix20210312\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'See diff of changes, do not save them to files.');
        $this->addOption(\Rector\Core\Configuration\Option::OPTION_AUTOLOAD_FILE, 'a', \RectorPrefix20210312\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'File with extra autoload');
        $names = $this->outputFormatterCollector->getNames();
        $description = \sprintf('Select output format: "%s".', \implode('", "', $names));
        $this->addOption(\Rector\Core\Configuration\Option::OPTION_OUTPUT_FORMAT, 'o', \RectorPrefix20210312\Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL, $description, \Rector\ChangesReporting\Output\ConsoleOutputFormatter::NAME);
        $this->addOption(\Rector\Core\Configuration\Option::OPTION_NO_PROGRESS_BAR, null, \RectorPrefix20210312\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Hide progress bar. Useful e.g. for nicer CI output.');
        $this->addOption(\Rector\Core\Configuration\Option::OPTION_NO_DIFFS, null, \RectorPrefix20210312\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Hide diffs of changed files. Useful e.g. for nicer CI output.');
        $this->addOption(\Rector\Core\Configuration\Option::OPTION_OUTPUT_FILE, null, \RectorPrefix20210312\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Location for file to dump result in. Useful for Docker or automated processes');
        $this->addOption(\Rector\Core\Configuration\Option::CACHE_DEBUG, null, \RectorPrefix20210312\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Debug changed file cache');
        $this->addOption(\Rector\Core\Configuration\Option::OPTION_CLEAR_CACHE, null, \RectorPrefix20210312\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Clear unchaged files cache');
    }
    protected function execute(\RectorPrefix20210312\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20210312\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $this->configuration->resolveFromInput($input);
        $this->configuration->validateConfigParameters();
        $this->configuration->setAreAnyPhpRectorsLoaded((bool) $this->rectorNodeTraverser->getPhpRectorCount());
        $this->rectorGuard->ensureSomeRectorsAreRegistered();
        $paths = $this->configuration->getPaths();
        $phpFileInfos = $this->phpFilesFinder->findInPaths($paths);
        $this->additionalAutoloader->autoloadWithInputAndSource($input);
        if ($this->configuration->isCacheDebug()) {
            $message = \sprintf('[cache] %d files after cache filter', \count($phpFileInfos));
            $this->symfonyStyle->note($message);
            $this->symfonyStyle->listing($phpFileInfos);
        }
        $this->configuration->setFileInfos($phpFileInfos);
        $this->rectorApplication->runOnPaths($paths);
        // must run after PHP rectors, because they might change class names, and these class names must be changed in configs
        $nonPhpFileInfos = $this->filesFinder->findInDirectoriesAndFiles($paths, \Rector\Core\ValueObject\StaticNonPhpFileSuffixes::SUFFIXES);
        $this->nonPhpFileProcessor->runOnFileInfos($nonPhpFileInfos);
        $composerJsonFilePath = \getcwd() . '/composer.json';
        $this->composerProcessor->process($composerJsonFilePath);
        $this->reportZeroCacheRectorsCondition();
        // report diffs and errors
        $outputFormat = (string) $input->getOption(\Rector\Core\Configuration\Option::OPTION_OUTPUT_FORMAT);
        $outputFormatter = $this->outputFormatterCollector->getByName($outputFormat);
        $outputFormatter->report($this->errorAndDiffCollector);
        // invalidate affected files
        $this->invalidateAffectedCacheFiles();
        // some errors were found → fail
        if ($this->errorAndDiffCollector->getErrors() !== []) {
            return \RectorPrefix20210312\Symplify\PackageBuilder\Console\ShellCode::ERROR;
        }
        // inverse error code for CI dry-run
        if (!$this->configuration->isDryRun()) {
            return \RectorPrefix20210312\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
        }
        if ($this->errorAndDiffCollector->getFileDiffsCount() === 0) {
            return \RectorPrefix20210312\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
        }
        return \RectorPrefix20210312\Symplify\PackageBuilder\Console\ShellCode::ERROR;
    }
    protected function initialize(\RectorPrefix20210312\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20210312\Symfony\Component\Console\Output\OutputInterface $output) : void
    {
        $application = $this->getApplication();
        if (!$application instanceof \RectorPrefix20210312\Symfony\Component\Console\Application) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $optionDebug = (bool) $input->getOption(\Rector\Core\Configuration\Option::OPTION_DEBUG);
        if ($optionDebug) {
            $application->setCatchExceptions(\false);
            // clear cache
            $this->changedFilesDetector->clear();
            return;
        }
        // clear cache
        $optionClearCache = (bool) $input->getOption(\Rector\Core\Configuration\Option::OPTION_CLEAR_CACHE);
        if ($optionClearCache) {
            $this->changedFilesDetector->clear();
        }
    }
    private function reportZeroCacheRectorsCondition() : void
    {
        if (!$this->configuration->isCacheEnabled()) {
            return;
        }
        if ($this->configuration->shouldClearCache()) {
            return;
        }
        if (!$this->rectorNodeTraverser->hasZeroCacheRectors()) {
            return;
        }
        if ($this->configuration->shouldHideClutter()) {
            return;
        }
        $message = \sprintf('Ruleset contains %d rules that need "--clear-cache" option to analyse full project', $this->rectorNodeTraverser->getZeroCacheRectorCount());
        $this->symfonyStyle->note($message);
    }
    private function invalidateAffectedCacheFiles() : void
    {
        if (!$this->configuration->isCacheEnabled()) {
            return;
        }
        foreach ($this->errorAndDiffCollector->getAffectedFileInfos() as $affectedFileInfo) {
            $this->changedFilesDetector->invalidateFile($affectedFileInfo);
        }
    }
}
