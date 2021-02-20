<?php

declare (strict_types=1);
namespace Rector\Core\Bootstrap;

use Rector\Set\RectorSetProvider;
use RectorPrefix20210220\Symfony\Component\Console\Input\ArgvInput;
use RectorPrefix20210220\Symplify\SetConfigResolver\ConfigResolver;
use RectorPrefix20210220\Symplify\SetConfigResolver\SetAwareConfigResolver;
use RectorPrefix20210220\Symplify\SmartFileSystem\SmartFileInfo;
final class RectorConfigsResolver
{
    /**
     * @var ConfigResolver
     */
    private $configResolver;
    /**
     * @var SetAwareConfigResolver
     */
    private $setAwareConfigResolver;
    /**
     * @var array<string, SmartFileInfo[]>
     */
    private $resolvedConfigFileInfos = [];
    public function __construct()
    {
        $this->configResolver = new \RectorPrefix20210220\Symplify\SetConfigResolver\ConfigResolver();
        $rectorSetProvider = new \Rector\Set\RectorSetProvider();
        $this->setAwareConfigResolver = new \RectorPrefix20210220\Symplify\SetConfigResolver\SetAwareConfigResolver($rectorSetProvider);
    }
    /**
     * @return SmartFileInfo[]
     */
    public function resolveFromConfigFileInfo(\RectorPrefix20210220\Symplify\SmartFileSystem\SmartFileInfo $configFileInfo) : array
    {
        $hash = \sha1($configFileInfo->getRealPath());
        if (isset($this->resolvedConfigFileInfos[$hash])) {
            return $this->resolvedConfigFileInfos[$hash];
        }
        $setFileInfos = $this->resolveSetFileInfosFromConfigFileInfos([$configFileInfo]);
        $configFileInfos = \array_merge([$configFileInfo], $setFileInfos);
        $this->resolvedConfigFileInfos[$hash] = $configFileInfos;
        return $configFileInfos;
    }
    /**
     * @noRector
     */
    public function getFirstResolvedConfig() : ?\RectorPrefix20210220\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->configResolver->getFirstResolvedConfigFileInfo();
    }
    /**
     * @param SmartFileInfo[] $configFileInfos
     * @return SmartFileInfo[]
     */
    public function resolveSetFileInfosFromConfigFileInfos(array $configFileInfos) : array
    {
        return $this->setAwareConfigResolver->resolveFromParameterSetsFromConfigFiles($configFileInfos);
    }
    /**
     * @return SmartFileInfo[]
     */
    public function provide() : array
    {
        $configFileInfos = [];
        $argvInput = new \RectorPrefix20210220\Symfony\Component\Console\Input\ArgvInput();
        $inputOrFallbackConfigFileInfo = $this->configResolver->resolveFromInputWithFallback($argvInput, ['rector.php']);
        if ($inputOrFallbackConfigFileInfo !== null) {
            $configFileInfos[] = $inputOrFallbackConfigFileInfo;
        }
        $setFileInfos = $this->resolveSetFileInfosFromConfigFileInfos($configFileInfos);
        if (\in_array($argvInput->getFirstArgument(), ['generate', 'g', 'create', 'c'], \true)) {
            // autoload rector recipe file if present, just for \Rector\RectorGenerator\Command\GenerateCommand
            $rectorRecipeFilePath = \getcwd() . '/rector-recipe.php';
            if (\file_exists($rectorRecipeFilePath)) {
                $configFileInfos[] = new \RectorPrefix20210220\Symplify\SmartFileSystem\SmartFileInfo($rectorRecipeFilePath);
            }
        }
        return \array_merge($configFileInfos, $setFileInfos);
    }
}
