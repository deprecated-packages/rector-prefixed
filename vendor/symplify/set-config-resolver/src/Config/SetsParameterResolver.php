<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SetConfigResolver\Config;

use _PhpScopere8e811afab72\Symfony\Component\Config\FileLocator;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use _PhpScopere8e811afab72\Symfony\Component\Yaml\Yaml;
use _PhpScopere8e811afab72\Symplify\SetConfigResolver\SetResolver;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScopere8e811afab72\Symplify\SetConfigResolver\SetResolver $setResolver)
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
    private function resolveSetsFromFileInfo(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $configFileInfo) : array
    {
        if ($configFileInfo->hasSuffixes(['yml', 'yaml'])) {
            return $this->resolveSetsParameterFromYamlFileInfo($configFileInfo);
        }
        return $this->resolveSetsParameterFromPhpFileInfo($configFileInfo);
    }
    /**
     * @return string[]
     */
    private function resolveSetsParameterFromYamlFileInfo(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $configFileInfo) : array
    {
        $configContent = \_PhpScopere8e811afab72\Symfony\Component\Yaml\Yaml::parse($configFileInfo->getContents());
        return (array) ($configContent['parameters'][self::SETS] ?? []);
    }
    /**
     * @return string[]
     */
    private function resolveSetsParameterFromPhpFileInfo(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $configFileInfo) : array
    {
        // php file loader
        $containerBuilder = new \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerBuilder();
        $phpFileLoader = new \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScopere8e811afab72\Symfony\Component\Config\FileLocator());
        $phpFileLoader->load($configFileInfo->getRealPath());
        if (!$containerBuilder->hasParameter(self::SETS)) {
            return [];
        }
        return (array) $containerBuilder->getParameter(self::SETS);
    }
}
