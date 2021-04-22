<?php

declare (strict_types=1);
namespace Rector\Core\ValueObject\Bootstrap;

use RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileInfo;
final class BootstrapConfigs
{
    /**
     * @var SmartFileInfo|null
     */
    private $mainConfigFileInfo;
    /**
     * @var SmartFileInfo[]
     */
    private $setConfigFileInfos = [];
    /**
     * @param SmartFileInfo[] $setConfigFileInfos
     * @param \Symplify\SmartFileSystem\SmartFileInfo|null $mainConfigFileInfo
     */
    public function __construct($mainConfigFileInfo, array $setConfigFileInfos)
    {
        $this->mainConfigFileInfo = $mainConfigFileInfo;
        $this->setConfigFileInfos = $setConfigFileInfos;
    }
    /**
     * @return \Symplify\SmartFileSystem\SmartFileInfo|null
     */
    public function getMainConfigFileInfo()
    {
        return $this->mainConfigFileInfo;
    }
    /**
     * @return SmartFileInfo[]
     */
    public function getConfigFileInfos() : array
    {
        $configFileInfos = [];
        if ($this->mainConfigFileInfo !== null) {
            $configFileInfos[] = $this->mainConfigFileInfo;
        }
        return \array_merge($configFileInfos, $this->setConfigFileInfos);
    }
}
