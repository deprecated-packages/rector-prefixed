<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\ChangesReporting\Collector;

use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class AffectedFilesCollector
{
    /**
     * @var SmartFileInfo[]
     */
    private $affectedFiles = [];
    public function addFile(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->affectedFiles[$fileInfo->getRealPath()] = $fileInfo;
    }
    public function getNext() : ?\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo
    {
        if ($this->affectedFiles !== []) {
            return \current($this->affectedFiles);
        }
        return null;
    }
    public function removeFromList(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        unset($this->affectedFiles[$fileInfo->getRealPath()]);
    }
}
