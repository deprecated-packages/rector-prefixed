<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Caching;

use _PhpScoperb75b35f52b74\Rector\Caching\Detector\ChangedFilesDetector;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class UnchangedFilesFilter
{
    /**
     * @var ChangedFilesDetector
     */
    private $changedFilesDetector;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Caching\Detector\ChangedFilesDetector $changedFilesDetector)
    {
        $this->changedFilesDetector = $changedFilesDetector;
    }
    /**
     * @param SmartFileInfo[] $fileInfos
     * @return SmartFileInfo[]
     */
    public function filterAndJoinWithDependentFileInfos(array $fileInfos) : array
    {
        $changedFileInfos = [];
        $dependentFileInfos = [];
        foreach ($fileInfos as $fileInfo) {
            if (!$this->changedFilesDetector->hasFileChanged($fileInfo)) {
                continue;
            }
            $changedFileInfos[] = $fileInfo;
            $this->changedFilesDetector->invalidateFile($fileInfo);
            $dependentFileInfos = \array_merge($dependentFileInfos, $this->changedFilesDetector->getDependentFileInfos($fileInfo));
        }
        // add dependent files
        $dependentFileInfos = \array_merge($dependentFileInfos, $changedFileInfos);
        return \array_unique($dependentFileInfos);
    }
}
