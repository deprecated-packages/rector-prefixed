<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\ChangesReporting\Collector;

use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class AffectedFilesCollector
{
    /**
     * @var SmartFileInfo[]
     */
    private $affectedFiles = [];
    public function addFile(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->affectedFiles[$fileInfo->getRealPath()] = $fileInfo;
    }
    public function getNext() : ?\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo
    {
        if ($this->affectedFiles !== []) {
            return \current($this->affectedFiles);
        }
        return null;
    }
    public function removeFromList(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        unset($this->affectedFiles[$fileInfo->getRealPath()]);
    }
}
