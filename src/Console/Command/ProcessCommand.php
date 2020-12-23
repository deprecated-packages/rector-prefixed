<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Console\Command;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\Rector\Caching\Application\CachedFileInfoFilterAndReporter;
use _PhpScoper0a2ac50786fa\Rector\Caching\Detector\ChangedFilesDetector;
use _PhpScoper0a2ac50786fa\Rector\ChangesReporting\Application\ErrorAndDiffCollector;
use _PhpScoper0a2ac50786fa\Rector\ChangesReporting\Output\ConsoleOutputFormatter;
use _PhpScoper0a2ac50786fa\Rector\Core\Application\RectorApplication;
use _PhpScoper0a2ac50786fa\Rector\Core\Autoloading\AdditionalAutoloader;
use _PhpScoper0a2ac50786fa\Rector\Core\Configuration\Configuration;
use _PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option;
use _PhpScoper0a2ac50786fa\Rector\Core\Console\Output\OutputFormatterCollector;
use _PhpScoper0a2ac50786fa\Rector\Core\FileSystem\FilesFinder;
use _PhpScoper0a2ac50786fa\Rector\Core\Guard\RectorGuard;
use _PhpScoper0a2ac50786fa\Rector\Core\NonPhpFile\NonPhpFileProcessor;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTraverser\RectorNodeTraverser;
use _PhpScoper0a2ac50786fa\Rector\Core\Stubs\StubLoader;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\StaticNonPhpFileSuffixes;
use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputArgument;
use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputOption;
use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\ShellCode;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class ProcessCommand extends \_PhpScoper0a2ac50786fa\Rector\Core\Console\Command\AbstractCommand
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
     * @var StubLoader
     */
    private $stubLoader;
    /**
     * @var NonPhpFileProcessor
     */
    private $nonPhpFileProcessor;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var CachedFileInfoFilterAndReporter
     */
    private $cachedFileInfoFilterAndReporter;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\Autoloading\AdditionalAutoloader $additionalAutoloader, \_PhpScoper0a2ac50786fa\Rector\Caching\Detector\ChangedFilesDetector $changedFilesDetector, \_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Configuration $configuration, \_PhpScoper0a2ac50786fa\Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector, \_PhpScoper0a2ac50786fa\Rector\Core\FileSystem\FilesFinder $phpFilesFinder, \_PhpScoper0a2ac50786fa\Rector\Core\NonPhpFile\NonPhpFileProcessor $nonPhpFileProcessor, \_PhpScoper0a2ac50786fa\Rector\Core\Console\Output\OutputFormatterCollector $outputFormatterCollector, \_PhpScoper0a2ac50786fa\Rector\Core\Application\RectorApplication $rectorApplication, \_PhpScoper0a2ac50786fa\Rector\Core\Guard\RectorGuard $rectorGuard, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTraverser\RectorNodeTraverser $rectorNodeTraverser, \_PhpScoper0a2ac50786fa\Rector\Core\Stubs\StubLoader $stubLoader, \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScoper0a2ac50786fa\Rector\Caching\Application\CachedFileInfoFilterAndReporter $cachedFileInfoFilterAndReporter)
    {
        $this->filesFinder = $phpFilesFinder;
        $this->additionalAutoloader = $additionalAutoloader;
        $this->rectorGuard = $rectorGuard;
        $this->errorAndDiffCollector = $errorAndDiffCollector;
        $this->configuration = $configuration;
        $this->rectorApplication = $rectorApplication;
        $this->outputFormatterCollector = $outputFormatterCollector;
        $this->rectorNodeTraverser = $rectorNodeTraverser;
        $this->stubLoader = $stubLoader;
        $this->nonPhpFileProcessor = $nonPhpFileProcessor;
        $this->changedFilesDetector = $changedFilesDetector;
        $this->symfonyStyle = $symfonyStyle;
        $this->cachedFileInfoFilterAndReporter = $cachedFileInfoFilterAndReporter;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setAliases(['rectify']);
        $this->setDescription('Upgrade or refactor source code with provided rectors');
        $this->addArgument(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::SOURCE, \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputArgument::OPTIONAL | \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Files or directories to be upgraded.');
        $this->addOption(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::OPTION_DRY_RUN, 'n', \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'See diff of changes, do not save them to files.');
        $this->addOption(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::OPTION_AUTOLOAD_FILE, 'a', \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'File with extra autoload');
        $this->addOption(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::MATCH_GIT_DIFF, null, \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Execute only on file(s) matching the git diff.');
        $names = $this->outputFormatterCollector->getNames();
        $description = \sprintf('Select output format: "%s".', \implode('", "', $names));
        $this->addOption(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::OPTION_OUTPUT_FORMAT, 'o', \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL, $description, \_PhpScoper0a2ac50786fa\Rector\ChangesReporting\Output\ConsoleOutputFormatter::NAME);
        $this->addOption(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::OPTION_NO_PROGRESS_BAR, null, \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Hide progress bar. Useful e.g. for nicer CI output.');
        $this->addOption(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::OPTION_OUTPUT_FILE, null, \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Location for file to dump result in. Useful for Docker or automated processes');
        $this->addOption(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::CACHE_DEBUG, null, \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Debug changed file cache');
        $this->addOption(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::OPTION_CLEAR_CACHE, null, \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Clear unchaged files cache');
    }
    protected function execute(\_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $this->configuration->resolveFromInput($input);
        $this->configuration->validateConfigParameters();
        $this->configuration->setAreAnyPhpRectorsLoaded((bool) $this->rectorNodeTraverser->getPhpRectorCount());
        $this->rectorGuard->ensureSomeRectorsAreRegistered();
        $this->stubLoader->loadStubs();
        $paths = $this->configuration->getPaths();
        $phpFileInfos = $this->findPhpFileInfos($paths);
        $this->additionalAutoloader->autoloadWithInputAndSource($input, $paths);
        if ($this->configuration->isCacheDebug()) {
            $message = \sprintf('[cache] %d files after cache filter', \count($phpFileInfos));
            $this->symfonyStyle->note($message);
            $this->symfonyStyle->listing($phpFileInfos);
        }
        $this->configuration->setFileInfos($phpFileInfos);
        $this->rectorApplication->runOnFileInfos($phpFileInfos);
        // must run after PHP rectors, because they might change class names, and these class names must be changed in configs
        $nonPhpFileInfos = $this->filesFinder->findInDirectoriesAndFiles($paths, \_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\StaticNonPhpFileSuffixes::SUFFIXES);
        $this->nonPhpFileProcessor->runOnFileInfos($nonPhpFileInfos);
        $this->reportZeroCacheRectorsCondition();
        // report diffs and errors
        $outputFormat = (string) $input->getOption(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::OPTION_OUTPUT_FORMAT);
        $outputFormatter = $this->outputFormatterCollector->getByName($outputFormat);
        $outputFormatter->report($this->errorAndDiffCollector);
        // invalidate affected files
        $this->invalidateAffectedCacheFiles();
        // some errors were found → fail
        if ($this->errorAndDiffCollector->getErrors() !== []) {
            return \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\ShellCode::ERROR;
        }
        // inverse error code for CI dry-run
        if ($this->configuration->isDryRun() && $this->errorAndDiffCollector->getFileDiffsCount()) {
            return \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\ShellCode::ERROR;
        }
        return \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
    /**
     * @param string[] $paths
     * @return SmartFileInfo[]
     */
    private function findPhpFileInfos(array $paths) : array
    {
        $phpFileInfos = $this->filesFinder->findInDirectoriesAndFiles($paths, $this->configuration->getFileExtensions(), $this->configuration->mustMatchGitDiff());
        // filter out non-PHP php files, e.g. blade templates in Laravel
        $phpFileInfos = \array_filter($phpFileInfos, function (\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool {
            return !\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::endsWith($smartFileInfo->getPathname(), '.blade.php');
        });
        return $this->cachedFileInfoFilterAndReporter->filterFileInfos($phpFileInfos);
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
