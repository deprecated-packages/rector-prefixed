<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\DependencyInjection;

use _PhpScoperb75b35f52b74\Psr\Container\ContainerInterface;
use _PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoperb75b35f52b74\Rector\Core\Stubs\StubLoader;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\Input\StaticInputDetector;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class RectorContainerFactory
{
    /**
     * @param SmartFileInfo[] $configFileInfos
     * @api
     */
    public function createFromConfigs(array $configFileInfos) : \_PhpScoperb75b35f52b74\Psr\Container\ContainerInterface
    {
        // to override the configs without clearing cache
        $environment = 'prod' . \random_int(1, 10000000);
        $isDebug = \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\Input\StaticInputDetector::isDebug();
        $rectorKernel = new \_PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel($environment, $isDebug);
        if ($configFileInfos !== []) {
            $configFilePaths = $this->unpackRealPathsFromFileInfos($configFileInfos);
            $rectorKernel->setConfigs($configFilePaths);
        }
        $stubLoader = new \_PhpScoperb75b35f52b74\Rector\Core\Stubs\StubLoader();
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
