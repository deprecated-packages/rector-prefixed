<?php

declare (strict_types=1);
namespace Rector\ChangesReporting\Collector;

use Rector\Core\ValueObject\Application\File;
final class AffectedFilesCollector
{
    /**
     * @var File[]
     */
    private $affectedFiles = [];
    /**
     * @return void
     */
    public function addFile(\Rector\Core\ValueObject\Application\File $file)
    {
        $smartFileInfo = $file->getSmartFileInfo();
        $this->affectedFiles[$smartFileInfo->getRealPath()] = $file;
    }
    public function getNext() : ?\Rector\Core\ValueObject\Application\File
    {
        if ($this->affectedFiles !== []) {
            return \current($this->affectedFiles);
        }
        return null;
    }
    /**
     * @return void
     */
    public function removeFromList(\Rector\Core\ValueObject\Application\File $file)
    {
        $smartFileInfo = $file->getSmartFileInfo();
        unset($this->affectedFiles[$smartFileInfo->getRealPath()]);
    }
}
