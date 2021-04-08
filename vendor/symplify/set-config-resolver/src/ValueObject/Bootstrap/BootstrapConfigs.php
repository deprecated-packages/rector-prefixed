<?php

declare (strict_types=1);
namespace RectorPrefix20210408\Symplify\SetConfigResolver\ValueObject\Bootstrap;

use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
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
     */
    public function __construct(?\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $mainConfigFileInfo, array $setConfigFileInfos)
    {
        $this->mainConfigFileInfo = $mainConfigFileInfo;
        $this->setConfigFileInfos = $setConfigFileInfos;
    }
    public function getMainConfigFileInfo() : ?\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->mainConfigFileInfo;
    }
    /**
     * @return SmartFileInfo[]
     */
    public function getConfigFileInfos() : array
    {
        if (!$this->mainConfigFileInfo instanceof \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo) {
            return $this->setConfigFileInfos;
        }
        return \array_merge($this->setConfigFileInfos, [$this->mainConfigFileInfo]);
    }
}
