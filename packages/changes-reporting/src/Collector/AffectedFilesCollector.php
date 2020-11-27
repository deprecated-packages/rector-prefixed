<?php

declare (strict_types=1);
namespace Rector\ChangesReporting\Collector;

use Symplify\SmartFileSystem\SmartFileInfo;
final class AffectedFilesCollector
{
    /**
     * @var SmartFileInfo[]
     */
    private $affectedFiles = [];
    public function addFile(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->affectedFiles[$fileInfo->getRealPath()] = $fileInfo;
    }
    public function getNext() : ?\Symplify\SmartFileSystem\SmartFileInfo
    {
        if ($this->affectedFiles !== []) {
            return \current($this->affectedFiles);
        }
        return null;
    }
    public function removeFromList(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        unset($this->affectedFiles[$fileInfo->getRealPath()]);
    }
}
