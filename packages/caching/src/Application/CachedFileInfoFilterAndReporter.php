<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Caching\Application;

use _PhpScoper2a4e7ab1ecbc\Rector\Caching\Detector\ChangedFilesDetector;
use _PhpScoper2a4e7ab1ecbc\Rector\Caching\UnchangedFilesFilter;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Configuration;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Configuration $configuration, \_PhpScoper2a4e7ab1ecbc\Rector\Caching\Detector\ChangedFilesDetector $changedFilesDetector, \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScoper2a4e7ab1ecbc\Rector\Caching\UnchangedFilesFilter $unchangedFilesFilter)
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
