<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Caching\Detector\ChangedFilesDetector;
use _PhpScoperb75b35f52b74\Rector\Core\Bootstrap\ConfigShifter;
use _PhpScoperb75b35f52b74\Rector\Core\Bootstrap\RectorConfigsResolver;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Configuration;
use _PhpScoperb75b35f52b74\Rector\Core\Console\ConsoleApplication;
use _PhpScoperb75b35f52b74\Rector\Core\Console\Style\SymfonyStyleFactory;
use _PhpScoperb75b35f52b74\Rector\Core\DependencyInjection\RectorContainerFactory;
use _PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\ShellCode;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Bootstrap\InvalidSetReporter;
use _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Exception\SetNotFoundException;
// @ intentionally: continue anyway
@\ini_set('memory_limit', '-1');
// Performance boost
\error_reporting(\E_ALL);
\ini_set('display_errors', 'stderr');
\gc_disable();
\define('__RECTOR_RUNNING__', \true);
// Require Composer autoload.php
$autoloadIncluder = new \_PhpScoperb75b35f52b74\AutoloadIncluder();
$autoloadIncluder->includeDependencyOrRepositoryVendorAutoloadIfExists();
$autoloadIncluder->loadIfExistsAndNotLoadedYet(__DIR__ . '/../vendor/scoper-autoload.php');
$autoloadIncluder->loadIfExistsAndNotLoadedYet(\getcwd() . '/vendor/autoload.php');
$autoloadIncluder->autoloadProjectAutoloaderFile();
$autoloadIncluder->autoloadFromCommandLine();
$symfonyStyleFactory = new \_PhpScoperb75b35f52b74\Rector\Core\Console\Style\SymfonyStyleFactory(new \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesCaller());
$symfonyStyle = $symfonyStyleFactory->create();
try {
    $rectorConfigsResolver = new \_PhpScoperb75b35f52b74\Rector\Core\Bootstrap\RectorConfigsResolver();
    $configFileInfos = $rectorConfigsResolver->provide();
    // Build DI container
    $rectorContainerFactory = new \_PhpScoperb75b35f52b74\Rector\Core\DependencyInjection\RectorContainerFactory();
    // shift configs as last so parameters with main config have higher priority
    $configShifter = new \_PhpScoperb75b35f52b74\Rector\Core\Bootstrap\ConfigShifter();
    $firstResolvedConfig = $rectorConfigsResolver->getFirstResolvedConfig();
    if ($firstResolvedConfig !== null) {
        $configFileInfos = $configShifter->shiftInputConfigAsLast($configFileInfos, $firstResolvedConfig);
    }
    $container = $rectorContainerFactory->createFromConfigs($configFileInfos);
    $firstResolvedConfig = $rectorConfigsResolver->getFirstResolvedConfig();
    if ($firstResolvedConfig) {
        /** @var Configuration $configuration */
        $configuration = $container->get(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Configuration::class);
        $configuration->setFirstResolverConfigFileInfo($firstResolvedConfig);
        /** @var ChangedFilesDetector $changedFilesDetector */
        $changedFilesDetector = $container->get(\_PhpScoperb75b35f52b74\Rector\Caching\Detector\ChangedFilesDetector::class);
        $changedFilesDetector->setFirstResolvedConfigFileInfo($firstResolvedConfig);
    }
} catch (\_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Exception\SetNotFoundException $setNotFoundException) {
    $invalidSetReporter = new \_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Bootstrap\InvalidSetReporter();
    $invalidSetReporter->report($setNotFoundException);
    exit(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\ShellCode::ERROR);
} catch (\Throwable $throwable) {
    $symfonyStyle->error($throwable->getMessage());
    exit(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\ShellCode::ERROR);
}
/** @var ConsoleApplication $application */
$application = $container->get(\_PhpScoperb75b35f52b74\Rector\Core\Console\ConsoleApplication::class);
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
        if (\class_exists(\_PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel::class)) {
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
\class_alias('_PhpScoperb75b35f52b74\\AutoloadIncluder', 'AutoloadIncluder', \false);
