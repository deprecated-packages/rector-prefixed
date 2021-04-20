<?php

declare (strict_types=1);
namespace RectorPrefix20210420\Symplify\SetConfigResolver\ValueObject\Bootstrap;

use RectorPrefix20210420\Symplify\SmartFileSystem\SmartFileInfo;
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
        if (!$this->mainConfigFileInfo instanceof \RectorPrefix20210420\Symplify\SmartFileSystem\SmartFileInfo) {
            return $this->setConfigFileInfos;
        }
        return \array_merge($this->setConfigFileInfos, [$this->mainConfigFileInfo]);
    }
}
