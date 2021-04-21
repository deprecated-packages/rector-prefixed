<?php

declare(strict_types=1);

namespace Rector\Core\Console\Command;

use PHPStan\Analyser\NodeScopeResolver;
use Rector\Caching\Detector\ChangedFilesDetector;
use Rector\ChangesReporting\Output\ConsoleOutputFormatter;
use Rector\Core\Application\ApplicationFileProcessor;
use Rector\Core\Autoloading\AdditionalAutoloader;
use Rector\Core\Autoloading\BootstrapFilesIncluder;
use Rector\Core\Configuration\Configuration;
use Rector\Core\Configuration\Option;
use Rector\Core\Console\Output\OutputFormatterCollector;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\FileSystem\PhpFilesFinder;
use Rector\Core\Reporting\MissingRectorRulesReporter;
use Rector\Core\StaticReflection\DynamicSourceLocatorDecorator;
use Rector\Core\ValueObject\ProcessResult;
use Rector\Core\ValueObjectFactory\Application\FileFactory;
use Rector\Core\ValueObjectFactory\ProcessResultFactory;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symplify\PackageBuilder\Console\ShellCode;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\SmartFileSystem\SmartFileInfo;

final class ProcessCommand extends Command
{
    /**
     * @var AdditionalAutoloader
     */
    private $additionalAutoloader;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var OutputFormatterCollector
     */
    private $outputFormatterCollector;

    /**
     * @var PhpFilesFinder
     */
    private $phpFilesFinder;

    /**
     * @var ChangedFilesDetector
     */
    private $changedFilesDetector;

    /**
     * @var MissingRectorRulesReporter
     */
    private $missingRectorRulesReporter;

//    /**
//     * @var ParameterProvider
//     */
//    private $parameterProvider;

    /**
     * @var ApplicationFileProcessor
     */
    private $applicationFileProcessor;

    /**
     * @var FileFactory
     */
    private $fileFactory;

    /**
     * @var BootstrapFilesIncluder
     */
    private $bootstrapFilesIncluder;

    /**
     * @var ProcessResultFactory
     */
    private $processResultFactory;

    /**
     * @var NodeScopeResolver
     */
    private $nodeScopeResolver;

    /**
     * @var DynamicSourceLocatorDecorator
     */
    private $dynamicSourceLocatorDecorator;

    public function __construct(
        AdditionalAutoloader $additionalAutoloader,
        ChangedFilesDetector $changedFilesDetector,
        Configuration $configuration,
        OutputFormatterCollector $outputFormatterCollector,
        PhpFilesFinder $phpFilesFinder,
        MissingRectorRulesReporter $missingRectorRulesReporter,
        ApplicationFileProcessor $applicationFileProcessor,
        FileFactory $fileFactory,
        BootstrapFilesIncluder $bootstrapFilesIncluder,
        ProcessResultFactory $processResultFactory,
        NodeScopeResolver $nodeScopeResolver,
        DynamicSourceLocatorDecorator $dynamicSourceLocatorDecorator
    ) {
        $this->additionalAutoloader = $additionalAutoloader;
        $this->configuration = $configuration;
        $this->outputFormatterCollector = $outputFormatterCollector;
        $this->changedFilesDetector = $changedFilesDetector;
        $this->phpFilesFinder = $phpFilesFinder;
        $this->missingRectorRulesReporter = $missingRectorRulesReporter;

        parent::__construct();
        $this->applicationFileProcessor = $applicationFileProcessor;
        $this->fileFactory = $fileFactory;
        $this->bootstrapFilesIncluder = $bootstrapFilesIncluder;
        $this->processResultFactory = $processResultFactory;
        $this->nodeScopeResolver = $nodeScopeResolver;
        $this->dynamicSourceLocatorDecorator = $dynamicSourceLocatorDecorator;
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setDescription('Upgrade or refactor source code with provided rectors');

        $this->addArgument(
            Option::SOURCE,
            InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
            'Files or directories to be upgraded.'
        );

        $this->addOption(
            Option::OPTION_DRY_RUN,
            'n',
            InputOption::VALUE_NONE,
            'See diff of changes, do not save them to files.'
        );

        $this->addOption(
            Option::OPTION_AUTOLOAD_FILE,
            'a',
            InputOption::VALUE_REQUIRED,
            'File with extra autoload'
        );

        $names = $this->outputFormatterCollector->getNames();

        $description = sprintf('Select output format: "%s".', implode('", "', $names));
        $this->addOption(
            Option::OPTION_OUTPUT_FORMAT,
            'o',
            InputOption::VALUE_OPTIONAL,
            $description,
            ConsoleOutputFormatter::NAME
        );

        $this->addOption(
            Option::OPTION_NO_PROGRESS_BAR,
            null,
            InputOption::VALUE_NONE,
            'Hide progress bar. Useful e.g. for nicer CI output.'
        );

        $this->addOption(
            Option::OPTION_NO_DIFFS,
            null,
            InputOption::VALUE_NONE,
            'Hide diffs of changed files. Useful e.g. for nicer CI output.'
        );

        $this->addOption(
            Option::OPTION_OUTPUT_FILE,
            null,
            InputOption::VALUE_REQUIRED,
            'Location for file to dump result in. Useful for Docker or automated processes'
        );

        $this->addOption(Option::CACHE_DEBUG, null, InputOption::VALUE_NONE, 'Debug changed file cache');
        $this->addOption(Option::OPTION_CLEAR_CACHE, null, InputOption::VALUE_NONE, 'Clear unchaged files cache');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $exitCode = $this->missingRectorRulesReporter->reportIfMissing();
        if ($exitCode !== null) {
            return $exitCode;
        }

        $this->configuration->resolveFromInput($input);
        $this->configuration->validateConfigParameters();

        $paths = $this->configuration->getPaths();
        $phpFileInfos = $this->phpFilesFinder->findInPaths($paths);

        // register autoloaded and included files
        $this->bootstrapFilesIncluder->includeBootstrapFiles();
        $this->additionalAutoloader->autoloadWithInputAndSource($input);

        // PHPStan has to know about all files!
        $this->configurePHPStanNodeScopeResolver($phpFileInfos);

        // 0. add files and directories to static locator
        $this->dynamicSourceLocatorDecorator->addPaths($paths);

        $files = $this->fileFactory->createFromPaths($paths);
        $this->applicationFileProcessor->run($files);

        // report diffs and errors
        $outputFormat = (string) $input->getOption(Option::OPTION_OUTPUT_FORMAT);

        $outputFormatter = $this->outputFormatterCollector->getByName($outputFormat);

        // here should be value obect factory
        $processResult = $this->processResultFactory->create($files);
        $outputFormatter->report($processResult);

        // invalidate affected files
        $this->invalidateCacheChangedFiles($processResult);

        return $this->resolveReturnCode($processResult);
    }

    /**
     * @return void
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $application = $this->getApplication();
        if (! $application instanceof Application) {
            throw new ShouldNotHappenException();
        }

        $optionDebug = (bool) $input->getOption(Option::OPTION_DEBUG);
        if ($optionDebug) {
            $application->setCatchExceptions(false);

            // clear cache
            $this->changedFilesDetector->clear();
            return;
        }

        // clear cache
        $optionClearCache = (bool) $input->getOption(Option::OPTION_CLEAR_CACHE);
        if ($optionClearCache) {
            $this->changedFilesDetector->clear();
        }
    }

    /**
     * @return void
     */
    private function invalidateCacheChangedFiles(ProcessResult $processResult)
    {
        if (! $this->configuration->isCacheEnabled()) {
            return;
        }

        foreach ($processResult->getChangedFileInfos() as $changedFileInfo) {
            $this->changedFilesDetector->invalidateFile($changedFileInfo);
        }
    }

    private function resolveReturnCode(ProcessResult $processResult): int
    {
        // some errors were found → fail
        if ($processResult->getErrors() !== []) {
            return ShellCode::ERROR;
        }

        // inverse error code for CI dry-run
        if (! $this->configuration->isDryRun()) {
            return ShellCode::SUCCESS;
        }

        return $processResult->getFileDiffs() === [] ? ShellCode::SUCCESS : ShellCode::ERROR;
    }

    /**
     * @param SmartFileInfo[] $fileInfos
     * @return void
     */
    private function configurePHPStanNodeScopeResolver(array $fileInfos)
    {
        $filePaths = [];
        foreach ($fileInfos as $fileInfo) {
            $filePaths[] = $fileInfo->getPathname();
        }

        $this->nodeScopeResolver->setAnalysedFiles($filePaths);
    }
}
