<?php

declare (strict_types=1);
namespace RectorPrefix20210211;

use Rector\Caching\Detector\ChangedFilesDetector;
use Rector\Core\Bootstrap\ConfigShifter;
use Rector\Core\Bootstrap\RectorConfigsResolver;
use Rector\Core\Configuration\Configuration;
use Rector\Core\Console\ConsoleApplication;
use Rector\Core\Console\Style\SymfonyStyleFactory;
use Rector\Core\DependencyInjection\RectorContainerFactory;
use Rector\Core\HttpKernel\RectorKernel;
use RectorPrefix20210211\Symplify\PackageBuilder\Console\ShellCode;
use RectorPrefix20210211\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use RectorPrefix20210211\Symplify\SetConfigResolver\Bootstrap\InvalidSetReporter;
use RectorPrefix20210211\Symplify\SetConfigResolver\Exception\SetNotFoundException;
// @ intentionally: continue anyway
@\ini_set('memory_limit', '-1');
// Performance boost
\error_reporting(\E_ALL);
\ini_set('display_errors', 'stderr');
\gc_disable();
\define('__RECTOR_RUNNING__', \true);
// Require Composer autoload.php
$autoloadIncluder = new \RectorPrefix20210211\AutoloadIncluder();
$autoloadIncluder->includeDependencyOrRepositoryVendorAutoloadIfExists();
$autoloadIncluder->loadIfExistsAndNotLoadedYet(__DIR__ . '/../vendor/scoper-autoload.php');
$autoloadIncluder->loadIfExistsAndNotLoadedYet(\getcwd() . '/vendor/autoload.php');
$autoloadIncluder->autoloadProjectAutoloaderFile();
$autoloadIncluder->autoloadFromCommandLine();
$symfonyStyleFactory = new \Rector\Core\Console\Style\SymfonyStyleFactory(new \RectorPrefix20210211\Symplify\PackageBuilder\Reflection\PrivatesCaller());
$symfonyStyle = $symfonyStyleFactory->create();
try {
    $rectorConfigsResolver = new \Rector\Core\Bootstrap\RectorConfigsResolver();
    $configFileInfos = $rectorConfigsResolver->provide();
    // Build DI container
    $rectorContainerFactory = new \Rector\Core\DependencyInjection\RectorContainerFactory();
    // shift configs as last so parameters with main config have higher priority
    $configShifter = new \Rector\Core\Bootstrap\ConfigShifter();
    $firstResolvedConfig = $rectorConfigsResolver->getFirstResolvedConfig();
    if ($firstResolvedConfig !== null) {
        $configFileInfos = $configShifter->shiftInputConfigAsLast($configFileInfos, $firstResolvedConfig);
    }
    $container = $rectorContainerFactory->createFromConfigs($configFileInfos);
    $firstResolvedConfig = $rectorConfigsResolver->getFirstResolvedConfig();
    if ($firstResolvedConfig) {
        /** @var Configuration $configuration */
        $configuration = $container->get(\Rector\Core\Configuration\Configuration::class);
        $configuration->setFirstResolverConfigFileInfo($firstResolvedConfig);
        /** @var ChangedFilesDetector $changedFilesDetector */
        $changedFilesDetector = $container->get(\Rector\Caching\Detector\ChangedFilesDetector::class);
        $changedFilesDetector->setFirstResolvedConfigFileInfo($firstResolvedConfig);
    }
} catch (\RectorPrefix20210211\Symplify\SetConfigResolver\Exception\SetNotFoundException $setNotFoundException) {
    $invalidSetReporter = new \RectorPrefix20210211\Symplify\SetConfigResolver\Bootstrap\InvalidSetReporter();
    $invalidSetReporter->report($setNotFoundException);
    exit(\RectorPrefix20210211\Symplify\PackageBuilder\Console\ShellCode::ERROR);
} catch (\Throwable $throwable) {
    $symfonyStyle->error($throwable->getMessage());
    exit(\RectorPrefix20210211\Symplify\PackageBuilder\Console\ShellCode::ERROR);
}
/** @var ConsoleApplication $application */
$application = $container->get(\Rector\Core\Console\ConsoleApplication::class);
exit($application->run());
final class AutoloadIncluder
{
    /**
     * @var string[]
     */
    private $alreadyLoadedAutoloadFiles = [];
    public function includeDependencyOrRepositoryVendorAutoloadIfExists() : void
    {
        // Rector's vendor is already loaded
        if (\class_exists(\Rector\Core\HttpKernel\RectorKernel::class)) {
            return;
        }
        // in Rector develop repository
        $this->loadIfExistsAndNotLoadedYet(__DIR__ . '/../vendor/autoload.php');
    }
    /**
     * In case Rector is installed as vendor dependency,
     * this autoloads the project vendor/autoload.php, including Rector
     */
    public function autoloadProjectAutoloaderFile() : void
    {
        $this->loadIfExistsAndNotLoadedYet(__DIR__ . '/../../autoload.php');
    }
    public function autoloadFromCommandLine() : void
    {
        $cliArgs = $_SERVER['argv'];
        $autoloadOptionPosition = \array_search('-a', $cliArgs, \true) ?: \array_search('--autoload-file', $cliArgs, \true);
        if (!$autoloadOptionPosition) {
            return;
        }
        $autoloadFileValuePosition = $autoloadOptionPosition + 1;
        $fileToAutoload = $cliArgs[$autoloadFileValuePosition] ?? null;
        if ($fileToAutoload === null) {
            return;
        }
        $this->loadIfExistsAndNotLoadedYet($fileToAutoload);
    }
    public function loadIfExistsAndNotLoadedYet(string $filePath) : void
    {
        if (!\file_exists($filePath)) {
            return;
        }
        if (\in_array($filePath, $this->alreadyLoadedAutoloadFiles, \true)) {
            return;
        }
        $this->alreadyLoadedAutoloadFiles[] = \realpath($filePath);
        require_once $filePath;
    }
}
\class_alias('RectorPrefix20210211\\AutoloadIncluder', 'AutoloadIncluder', \false);
