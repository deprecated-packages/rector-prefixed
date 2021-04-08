<?php

declare (strict_types=1);
namespace Rector\Core\DependencyInjection;

use Rector\Caching\Detector\ChangedFilesDetector;
use Rector\Core\Configuration\Configuration;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\Core\Stubs\PHPStanStubLoader;
use Rector\Core\ValueObject\Bootstrap\BootstrapConfigs;
use Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\ContainerInterface;
use RectorPrefix20210408\Symplify\PackageBuilder\Console\Input\StaticInputDetector;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
final class RectorContainerFactory
{
    /**
     * @param SmartFileInfo[] $configFileInfos
     * @api
     */
    public function createFromConfigs(array $configFileInfos) : \RectorPrefix20210408\Symfony\Component\DependencyInjection\ContainerInterface
    {
        // to override the configs without clearing cache
        $isDebug = \RectorPrefix20210408\Symplify\PackageBuilder\Console\Input\StaticInputDetector::isDebug();
        $environment = $this->createEnvironment($configFileInfos);
        // mt_rand is needed to invalidate container cache in case of class changes to be registered as services
        $isPHPUnitRun = \Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun();
        if (!$isPHPUnitRun) {
            $environment .= \mt_rand(0, 10000);
        }
        $rectorKernel = new \Rector\Core\HttpKernel\RectorKernel($environment, $isDebug);
        if ($configFileInfos !== []) {
            $configFilePaths = $this->unpackRealPathsFromFileInfos($configFileInfos);
            $rectorKernel->setConfigs($configFilePaths);
        }
        $phpStanStubLoader = new \Rector\Core\Stubs\PHPStanStubLoader();
        $phpStanStubLoader->loadStubs();
        $rectorKernel->boot();
        return $rectorKernel->getContainer();
    }
    public function createFromBootstrapConfigs(\Rector\Core\ValueObject\Bootstrap\BootstrapConfigs $bootstrapConfigs) : \RectorPrefix20210408\Symfony\Component\DependencyInjection\ContainerInterface
    {
        $container = $this->createFromConfigs($bootstrapConfigs->getConfigFileInfos());
        $mainConfigFileInfo = $bootstrapConfigs->getMainConfigFileInfo();
        if ($mainConfigFileInfo !== null) {
            /** @var ChangedFilesDetector $changedFilesDetector */
            $changedFilesDetector = $container->get(\Rector\Caching\Detector\ChangedFilesDetector::class);
            $changedFilesDetector->setFirstResolvedConfigFileInfo($mainConfigFileInfo);
        }
        /** @var Configuration $configuration */
        $configuration = $container->get(\Rector\Core\Configuration\Configuration::class);
        $configuration->setBootstrapConfigs($bootstrapConfigs);
        return $container;
    }
    /**
     * @param SmartFileInfo[] $configFileInfos
     * @return string[]
     */
    private function unpackRealPathsFromFileInfos(array $configFileInfos) : array
    {
        $configFilePaths = [];
        foreach ($configFileInfos as $configFileInfo) {
            // getRealPath() cannot be used, as it breaks in phar
            $configFilePaths[] = $configFileInfo->getRealPath() ?: $configFileInfo->getPathname();
        }
        return $configFilePaths;
    }
    /**
     * @see https://symfony.com/doc/current/components/dependency_injection/compilation.html#dumping-the-configuration-for-performance
     * @param SmartFileInfo[] $configFileInfos
     */
    private function createEnvironment(array $configFileInfos) : string
    {
        $configHashes = [];
        foreach ($configFileInfos as $configFileInfo) {
            $configHashes[] = \md5_file($configFileInfo->getRealPath());
        }
        $configHashString = \implode('', $configHashes);
        return \sha1($configHashString);
    }
}
