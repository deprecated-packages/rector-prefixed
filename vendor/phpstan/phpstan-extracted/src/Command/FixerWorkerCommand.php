<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Command;

use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\Json;
use RectorPrefix20201227\PHPStan\Analyser\AnalyserResult;
use RectorPrefix20201227\PHPStan\Analyser\IgnoredErrorHelper;
use RectorPrefix20201227\PHPStan\Analyser\ResultCache\ResultCacheManager;
use RectorPrefix20201227\PHPStan\Analyser\ResultCache\ResultCacheManagerFactory;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Command\Command;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputArgument;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Output\OutputInterface;
class FixerWorkerCommand extends \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Command\Command
{
    private const NAME = 'fixer:worker';
    /** @var string[] */
    private $composerAutoloaderProjectPaths;
    /**
     * @param string[] $composerAutoloaderProjectPaths
     */
    public function __construct(array $composerAutoloaderProjectPaths)
    {
        parent::__construct();
        $this->composerAutoloaderProjectPaths = $composerAutoloaderProjectPaths;
    }
    protected function configure() : void
    {
        $this->setName(self::NAME)->setDescription('(Internal) Support for PHPStan Pro.')->setDefinition([new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputArgument('paths', \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputArgument::OPTIONAL | \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Paths with source code to run analysis on'), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption('paths-file', null, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to a file with a list of paths to run analysis on'), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption('configuration', 'c', \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to project configuration file'), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption(\RectorPrefix20201227\PHPStan\Command\AnalyseCommand::OPTION_LEVEL, 'l', \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Level of rule options - the higher the stricter'), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption('autoload-file', 'a', \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Project\'s additional autoload file path'), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption('memory-limit', null, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Memory limit for analysis'), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption('xdebug', null, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Allow running with XDebug for debugging purposes'), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption('tmp-file', null, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption('instead-of', null, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption('save-result-cache', null, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL, '', \false), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption('restore-result-cache', null, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption('allow-parallel', null, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Allow parallel analysis')]);
    }
    protected function execute(\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $paths = $input->getArgument('paths');
        $memoryLimit = $input->getOption('memory-limit');
        $autoloadFile = $input->getOption('autoload-file');
        $configuration = $input->getOption('configuration');
        $level = $input->getOption(\RectorPrefix20201227\PHPStan\Command\AnalyseCommand::OPTION_LEVEL);
        $pathsFile = $input->getOption('paths-file');
        $allowXdebug = $input->getOption('xdebug');
        $allowParallel = $input->getOption('allow-parallel');
        if (!\is_array($paths) || !\is_string($memoryLimit) && $memoryLimit !== null || !\is_string($autoloadFile) && $autoloadFile !== null || !\is_string($configuration) && $configuration !== null || !\is_string($level) && $level !== null || !\is_string($pathsFile) && $pathsFile !== null || !\is_bool($allowXdebug) || !\is_bool($allowParallel)) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        /** @var string|null $tmpFile */
        $tmpFile = $input->getOption('tmp-file');
        /** @var string|null $insteadOfFile */
        $insteadOfFile = $input->getOption('instead-of');
        /** @var false|string|null $saveResultCache */
        $saveResultCache = $input->getOption('save-result-cache');
        /** @var string|null $restoreResultCache */
        $restoreResultCache = $input->getOption('restore-result-cache');
        if (\is_string($tmpFile)) {
            if (!\is_string($insteadOfFile)) {
                throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
            }
        } elseif (\is_string($insteadOfFile)) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        } elseif ($saveResultCache === \false) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        $singleReflectionFile = null;
        if ($tmpFile !== null) {
            $singleReflectionFile = $tmpFile;
        }
        try {
            $inceptionResult = \RectorPrefix20201227\PHPStan\Command\CommandHelper::begin($input, $output, $paths, $pathsFile, $memoryLimit, $autoloadFile, $this->composerAutoloaderProjectPaths, $configuration, null, $level, $allowXdebug, \false, \false, $singleReflectionFile);
        } catch (\RectorPrefix20201227\PHPStan\Command\InceptionNotSuccessfulException $e) {
            return 1;
        }
        $container = $inceptionResult->getContainer();
        /** @var IgnoredErrorHelper $ignoredErrorHelper */
        $ignoredErrorHelper = $container->getByType(\RectorPrefix20201227\PHPStan\Analyser\IgnoredErrorHelper::class);
        $ignoredErrorHelperResult = $ignoredErrorHelper->initialize();
        if (\count($ignoredErrorHelperResult->getErrors()) > 0) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        /** @var AnalyserRunner $analyserRunner */
        $analyserRunner = $container->getByType(\RectorPrefix20201227\PHPStan\Command\AnalyserRunner::class);
        $fileReplacements = [];
        if ($insteadOfFile !== null && $tmpFile !== null) {
            $fileReplacements = [$insteadOfFile => $tmpFile];
        }
        /** @var ResultCacheManager $resultCacheManager */
        $resultCacheManager = $container->getByType(\RectorPrefix20201227\PHPStan\Analyser\ResultCache\ResultCacheManagerFactory::class)->create($fileReplacements);
        $projectConfigArray = $inceptionResult->getProjectConfigArray();
        [$inceptionFiles, $isOnlyFiles] = $inceptionResult->getFiles();
        $resultCache = $resultCacheManager->restore($inceptionFiles, \false, \false, $projectConfigArray, $inceptionResult->getErrorOutput(), $restoreResultCache);
        $intermediateAnalyserResult = $analyserRunner->runAnalyser($resultCache->getFilesToAnalyse(), $inceptionFiles, null, null, \false, $allowParallel, $configuration, $tmpFile, $insteadOfFile, $input);
        $result = $resultCacheManager->process($this->switchTmpFileInAnalyserResult($intermediateAnalyserResult, $tmpFile, $insteadOfFile), $resultCache, $inceptionResult->getErrorOutput(), \false, $projectConfigArray, \is_string($saveResultCache) ? $saveResultCache : $saveResultCache === null)->getAnalyserResult();
        $intermediateErrors = $ignoredErrorHelperResult->process($result->getErrors(), $isOnlyFiles, $inceptionFiles, \count($result->getInternalErrors()) > 0 || $result->hasReachedInternalErrorsCountLimit());
        $finalFileSpecificErrors = [];
        $finalNotFileSpecificErrors = [];
        foreach ($intermediateErrors as $intermediateError) {
            if (\is_string($intermediateError)) {
                $finalNotFileSpecificErrors[] = $intermediateError;
                continue;
            }
            $finalFileSpecificErrors[] = $intermediateError;
        }
        $output->writeln(\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\Json::encode(['fileSpecificErrors' => $finalFileSpecificErrors, 'notFileSpecificErrors' => $finalNotFileSpecificErrors]), \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Output\OutputInterface::OUTPUT_RAW);
        return 0;
    }
    private function switchTmpFileInAnalyserResult(\RectorPrefix20201227\PHPStan\Analyser\AnalyserResult $analyserResult, ?string $insteadOfFile, ?string $tmpFile) : \RectorPrefix20201227\PHPStan\Analyser\AnalyserResult
    {
        $fileSpecificErrors = [];
        foreach ($analyserResult->getErrors() as $error) {
            if ($tmpFile !== null && $insteadOfFile !== null) {
                if ($error->getFilePath() === $insteadOfFile) {
                    $error = $error->changeFilePath($tmpFile);
                }
                if ($error->getTraitFilePath() === $insteadOfFile) {
                    $error = $error->changeTraitFilePath($tmpFile);
                }
            }
            $fileSpecificErrors[] = $error;
        }
        $dependencies = null;
        if ($analyserResult->getDependencies() !== null) {
            $dependencies = [];
            foreach ($analyserResult->getDependencies() as $dependencyFile => $dependentFiles) {
                $new = [];
                foreach ($dependentFiles as $file) {
                    if ($file === $insteadOfFile && $tmpFile !== null) {
                        $new[] = $tmpFile;
                        continue;
                    }
                    $new[] = $file;
                }
                $key = $dependencyFile;
                if ($key === $insteadOfFile && $tmpFile !== null) {
                    $key = $tmpFile;
                }
                $dependencies[$key] = $new;
            }
        }
        $exportedNodes = [];
        foreach ($analyserResult->getExportedNodes() as $file => $fileExportedNodes) {
            if ($tmpFile !== null && $insteadOfFile !== null && $file === $insteadOfFile) {
                $file = $tmpFile;
            }
            $exportedNodes[$file] = $fileExportedNodes;
        }
        return new \RectorPrefix20201227\PHPStan\Analyser\AnalyserResult($fileSpecificErrors, $analyserResult->getInternalErrors(), $dependencies, $exportedNodes, $analyserResult->hasReachedInternalErrorsCountLimit());
    }
}
