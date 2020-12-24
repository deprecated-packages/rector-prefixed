<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Bootstrap;

use _PhpScoper0a6b37af0871\Rector\Set\RectorSetProvider;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Input\ArgvInput;
use _PhpScoper0a6b37af0871\Symplify\SetConfigResolver\ConfigResolver;
use _PhpScoper0a6b37af0871\Symplify\SetConfigResolver\SetAwareConfigResolver;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct()
    {
        $this->configResolver = new \_PhpScoper0a6b37af0871\Symplify\SetConfigResolver\ConfigResolver();
        $rectorSetProvider = new \_PhpScoper0a6b37af0871\Rector\Set\RectorSetProvider();
        $this->setAwareConfigResolver = new \_PhpScoper0a6b37af0871\Symplify\SetConfigResolver\SetAwareConfigResolver($rectorSetProvider);
    }
    /**
     * @noRector
     */
    public function getFirstResolvedConfig() : ?\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo
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
        $argvInput = new \_PhpScoper0a6b37af0871\Symfony\Component\Console\Input\ArgvInput();
        $inputOrFallbackConfigFileInfo = $this->configResolver->resolveFromInputWithFallback($argvInput, ['rector.php']);
        if ($inputOrFallbackConfigFileInfo !== null) {
            $configFileInfos[] = $inputOrFallbackConfigFileInfo;
        }
        $setFileInfos = $this->resolveSetFileInfosFromConfigFileInfos($configFileInfos);
        if (\in_array($argvInput->getFirstArgument(), ['generate', 'g', 'create', 'c'], \true)) {
            // autoload rector recipe file if present, just for \Rector\RectorGenerator\Command\GenerateCommand
            $rectorRecipeFilePath = \getcwd() . '/rector-recipe.php';
            if (\file_exists($rectorRecipeFilePath)) {
                $configFileInfos[] = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo($rectorRecipeFilePath);
            }
        }
        return \array_merge($configFileInfos, $setFileInfos);
    }
}
