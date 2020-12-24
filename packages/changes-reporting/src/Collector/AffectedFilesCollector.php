<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\ChangesReporting\Collector;

use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class AffectedFilesCollector
{
    /**
     * @var SmartFileInfo[]
     */
    private $affectedFiles = [];
    public function addFile(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->affectedFiles[$fileInfo->getRealPath()] = $fileInfo;
    }
    public function getNext() : ?\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo
    {
        if ($this->affectedFiles !== []) {
            return \current($this->affectedFiles);
        }
        return null;
    }
    public function removeFromList(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        unset($this->affectedFiles[$fileInfo->getRealPath()]);
    }
}
