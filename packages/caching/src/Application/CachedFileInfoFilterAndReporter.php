<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Caching\Application;

use _PhpScopere8e811afab72\Rector\Caching\Detector\ChangedFilesDetector;
use _PhpScopere8e811afab72\Rector\Caching\UnchangedFilesFilter;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Configuration;
use _PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class CachedFileInfoFilterAndReporter
{
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var ChangedFilesDetector
     */
    private $changedFilesDetector;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var UnchangedFilesFilter
     */
    private $unchangedFilesFilter;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\Configuration\Configuration $configuration, \_PhpScopere8e811afab72\Rector\Caching\Detector\ChangedFilesDetector $changedFilesDetector, \_PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScopere8e811afab72\Rector\Caching\UnchangedFilesFilter $unchangedFilesFilter)
    {
        $this->configuration = $configuration;
        $this->changedFilesDetector = $changedFilesDetector;
        $this->symfonyStyle = $symfonyStyle;
        $this->unchangedFilesFilter = $unchangedFilesFilter;
    }
    /**
     * @param SmartFileInfo[] $phpFileInfos
     * @return SmartFileInfo[]
     */
    public function filterFileInfos(array $phpFileInfos) : array
    {
        if (!$this->configuration->isCacheEnabled()) {
            return $phpFileInfos;
        }
        // cache stuff
        if ($this->configuration->shouldClearCache()) {
            $this->changedFilesDetector->clear();
        }
        if ($this->configuration->isCacheDebug()) {
            $message = \sprintf('[cache] %d files before cache filter', \count($phpFileInfos));
            $this->symfonyStyle->note($message);
        }
        return $this->unchangedFilesFilter->filterAndJoinWithDependentFileInfos($phpFileInfos);
    }
}
