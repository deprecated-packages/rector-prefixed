<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Config;

use _PhpScoperb75b35f52b74\Symfony\Component\Config\FileLocator;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use _PhpScoperb75b35f52b74\Symfony\Component\Yaml\Yaml;
use _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\SetResolver;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class SetsParameterResolver
{
    /**
     * @var string
     */
    private const SETS = 'sets';
    /**
     * @var SetResolver
     */
    private $setResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\SetResolver $setResolver)
    {
        $this->setResolver = $setResolver;
    }
    /**
     * @param SmartFileInfo[] $fileInfos
     * @return SmartFileInfo[]
     */
    public function resolveFromFileInfos(array $fileInfos) : array
    {
        $setFileInfos = [];
        foreach ($fileInfos as $fileInfo) {
            $setsNames = $this->resolveSetsFromFileInfo($fileInfo);
            foreach ($setsNames as $setsName) {
                $setFileInfos[] = $this->setResolver->detectFromName($setsName);
            }
        }
        return $setFileInfos;
    }
    /**
     * @return string[]
     */
    private function resolveSetsFromFileInfo(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $configFileInfo) : array
    {
        if ($configFileInfo->hasSuffixes(['yml', 'yaml'])) {
            return $this->resolveSetsParameterFromYamlFileInfo($configFileInfo);
        }
        return $this->resolveSetsParameterFromPhpFileInfo($configFileInfo);
    }
    /**
     * @return string[]
     */
    private function resolveSetsParameterFromYamlFileInfo(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $configFileInfo) : array
    {
        $configContent = \_PhpScoperb75b35f52b74\Symfony\Component\Yaml\Yaml::parse($configFileInfo->getContents());
        return (array) ($configContent['parameters'][self::SETS] ?? []);
    }
    /**
     * @return string[]
     */
    private function resolveSetsParameterFromPhpFileInfo(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $configFileInfo) : array
    {
        // php file loader
        $containerBuilder = new \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerBuilder();
        $phpFileLoader = new \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoperb75b35f52b74\Symfony\Component\Config\FileLocator());
        $phpFileLoader->load($configFileInfo->getRealPath());
        if (!$containerBuilder->hasParameter(self::SETS)) {
            return [];
        }
        return (array) $containerBuilder->getParameter(self::SETS);
    }
}
