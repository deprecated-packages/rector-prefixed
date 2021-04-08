<?php

declare (strict_types=1);
namespace Rector\Core\NonPhpFile;

use Rector\ChangesReporting\Application\ErrorAndDiffCollector;
use Rector\Core\Configuration\Configuration;
use Rector\Core\Configuration\RenamedClassesDataCollector;
use Rector\PSR4\Collector\RenamedClassesCollector;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * @see \Rector\Tests\Renaming\Rector\Name\RenameClassRector\RenameNonPhpTest
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
    /**
     * @var ErrorAndDiffCollector
     */
    private $errorAndDiffCollector;
    public function __construct(\Rector\Core\Configuration\RenamedClassesDataCollector $renamedClassesDataCollector, \Rector\Core\Configuration\Configuration $configuration, \Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector, \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \Rector\Core\NonPhpFile\NonPhpFileClassRenamer $nonPhpFileClassRenamer, \Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector)
    {
        $this->configuration = $configuration;
        $this->renamedClassesDataCollector = $renamedClassesDataCollector;
        $this->renamedClassesCollector = $renamedClassesCollector;
        $this->smartFileSystem = $smartFileSystem;
        $this->nonPhpFileClassRenamer = $nonPhpFileClassRenamer;
        $this->errorAndDiffCollector = $errorAndDiffCollector;
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
    public function processFileInfo(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        $oldContents = $smartFileInfo->getContents();
        $classRenames = \array_merge($this->renamedClassesDataCollector->getOldToNewClasses(), $this->renamedClassesCollector->getOldToNewClasses());
        $newContents = $this->nonPhpFileClassRenamer->renameClasses($oldContents, $classRenames);
        // nothing has changed
        if ($oldContents === $newContents) {
            return $oldContents;
        }
        $this->reportFileContentChange($smartFileInfo, $newContents, $oldContents);
        return $newContents;
    }
    private function reportFileContentChange(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, string $newContents, string $oldContents) : void
    {
        $this->errorAndDiffCollector->addFileDiff($smartFileInfo, $newContents, $oldContents);
        if (!$this->configuration->isDryRun()) {
            $this->smartFileSystem->dumpFile($smartFileInfo->getRealPath(), $newContents);
            $this->smartFileSystem->chmod($smartFileInfo->getRealPath(), $smartFileInfo->getPerms());
        }
    }
}
