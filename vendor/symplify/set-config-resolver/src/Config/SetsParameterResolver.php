<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Config;

use _PhpScoper0a2ac50786fa\Symfony\Component\Config\FileLocator;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use _PhpScoper0a2ac50786fa\Symfony\Component\Yaml\Yaml;
use _PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\SetResolver;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\SetResolver $setResolver)
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
    private function resolveSetsFromFileInfo(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $configFileInfo) : array
    {
        if ($configFileInfo->hasSuffixes(['yml', 'yaml'])) {
            return $this->resolveSetsParameterFromYamlFileInfo($configFileInfo);
        }
        return $this->resolveSetsParameterFromPhpFileInfo($configFileInfo);
    }
    /**
     * @return string[]
     */
    private function resolveSetsParameterFromYamlFileInfo(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $configFileInfo) : array
    {
        $configContent = \_PhpScoper0a2ac50786fa\Symfony\Component\Yaml\Yaml::parse($configFileInfo->getContents());
        return (array) ($configContent['parameters'][self::SETS] ?? []);
    }
    /**
     * @return string[]
     */
    private function resolveSetsParameterFromPhpFileInfo(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $configFileInfo) : array
    {
        // php file loader
        $containerBuilder = new \_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\ContainerBuilder();
        $phpFileLoader = new \_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoper0a2ac50786fa\Symfony\Component\Config\FileLocator());
        $phpFileLoader->load($configFileInfo->getRealPath());
        if (!$containerBuilder->hasParameter(self::SETS)) {
            return [];
        }
        return (array) $containerBuilder->getParameter(self::SETS);
    }
}
