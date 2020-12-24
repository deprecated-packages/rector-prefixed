<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\NonPhpFile;

use _PhpScopere8e811afab72\Rector\Core\Configuration\Configuration;
use _PhpScopere8e811afab72\Rector\Core\Configuration\RenamedClassesDataCollector;
use _PhpScopere8e811afab72\Rector\PSR4\Collector\RenamedClassesCollector;
use _PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * @see \Rector\Renaming\Tests\Rector\Name\RenameClassRector\RenameNonPhpTest
 */
final class NonPhpFileProcessor
{
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var RenamedClassesDataCollector
     */
    private $renamedClassesDataCollector;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var RenamedClassesCollector
     */
    private $renamedClassesCollector;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var NonPhpFileClassRenamer
     */
    private $nonPhpFileClassRenamer;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\Configuration\RenamedClassesDataCollector $renamedClassesDataCollector, \_PhpScopere8e811afab72\Rector\Core\Configuration\Configuration $configuration, \_PhpScopere8e811afab72\Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScopere8e811afab72\Rector\Core\NonPhpFile\NonPhpFileClassRenamer $nonPhpFileClassRenamer)
    {
        $this->configuration = $configuration;
        $this->renamedClassesDataCollector = $renamedClassesDataCollector;
        $this->symfonyStyle = $symfonyStyle;
        $this->renamedClassesCollector = $renamedClassesCollector;
        $this->smartFileSystem = $smartFileSystem;
        $this->nonPhpFileClassRenamer = $nonPhpFileClassRenamer;
    }
    /**
     * @param SmartFileInfo[] $nonPhpFileInfos
     */
    public function runOnFileInfos(array $nonPhpFileInfos) : void
    {
        foreach ($nonPhpFileInfos as $nonPhpFileInfo) {
            $this->processFileInfo($nonPhpFileInfo);
        }
    }
    public function processFileInfo(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        $oldContents = $smartFileInfo->getContents();
        $classRenames = \array_merge($this->renamedClassesDataCollector->getOldToNewClasses(), $this->renamedClassesCollector->getOldToNewClasses());
        $newContents = $this->nonPhpFileClassRenamer->renameClasses($oldContents, $classRenames);
        // nothing has changed
        if ($oldContents === $newContents) {
            return $oldContents;
        }
        $this->reportFileContentChange($smartFileInfo, $newContents);
        return $newContents;
    }
    private function reportFileContentChange(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, string $newContent) : void
    {
        $relativeFilePathFromCwd = $smartFileInfo->getRelativeFilePathFromCwd();
        if ($this->configuration->isDryRun()) {
            $message = \sprintf('File "%s" would be changed ("dry-run" is on now)', $relativeFilePathFromCwd);
            $this->symfonyStyle->note($message);
        } else {
            $message = \sprintf('File "%s" was changed', $relativeFilePathFromCwd);
            $this->symfonyStyle->note($message);
            $this->smartFileSystem->dumpFile($smartFileInfo->getRealPath(), $newContent);
            $this->smartFileSystem->chmod($smartFileInfo->getRealPath(), $smartFileInfo->getPerms());
        }
    }
}
