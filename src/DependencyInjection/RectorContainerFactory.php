<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\DependencyInjection;

use _PhpScoper0a6b37af0871\Psr\Container\ContainerInterface;
use _PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper0a6b37af0871\Rector\Core\Stubs\StubLoader;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\Input\StaticInputDetector;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class RectorContainerFactory
{
    /**
     * @param SmartFileInfo[] $configFileInfos
     * @api
     */
    public function createFromConfigs(array $configFileInfos) : \_PhpScoper0a6b37af0871\Psr\Container\ContainerInterface
    {
        // to override the configs without clearing cache
        $environment = 'prod' . \random_int(1, 10000000);
        $isDebug = \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\Input\StaticInputDetector::isDebug();
        $rectorKernel = new \_PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel($environment, $isDebug);
        if ($configFileInfos !== []) {
            $configFilePaths = $this->unpackRealPathsFromFileInfos($configFileInfos);
            $rectorKernel->setConfigs($configFilePaths);
        }
        $stubLoader = new \_PhpScoper0a6b37af0871\Rector\Core\Stubs\StubLoader();
        $stubLoader->loadStubs();
        $rectorKernel->boot();
        return $rectorKernel->getContainer();
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
}
