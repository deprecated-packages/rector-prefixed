<?php

declare (strict_types=1);
namespace Rector\Core\NonPhpFile;

use Rector\Core\Configuration\RenamedClassesDataCollector;
use Rector\Core\Contract\Processor\FileProcessorInterface;
use Rector\Core\ValueObject\NonPhpFile\NonPhpFileChange;
use Rector\Core\ValueObject\StaticNonPhpFileSuffixes;
use Rector\PSR4\Collector\RenamedClassesCollector;
use RectorPrefix20210410\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\Tests\Renaming\Rector\Name\RenameClassRector\RenameNonPhpTest
 */
final class NonPhpFileProcessor implements \Rector\Core\Contract\Processor\FileProcessorInterface
{
    /**
     * @var RenamedClassesDataCollector
     */
    private $renamedClassesDataCollector;
    /**
     * @var RenamedClassesCollector
     */
    private $renamedClassesCollector;
    /**
     * @var NonPhpFileClassRenamer
     */
    private $nonPhpFileClassRenamer;
    public function __construct(\Rector\Core\Configuration\RenamedClassesDataCollector $renamedClassesDataCollector, \Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector, \Rector\Core\NonPhpFile\NonPhpFileClassRenamer $nonPhpFileClassRenamer)
    {
        $this->renamedClassesDataCollector = $renamedClassesDataCollector;
        $this->renamedClassesCollector = $renamedClassesCollector;
        $this->nonPhpFileClassRenamer = $nonPhpFileClassRenamer;
    }
    public function process(\RectorPrefix20210410\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : ?\Rector\Core\ValueObject\NonPhpFile\NonPhpFileChange
    {
        $oldContents = $smartFileInfo->getContents();
        $classRenames = \array_merge($this->renamedClassesDataCollector->getOldToNewClasses(), $this->renamedClassesCollector->getOldToNewClasses());
        $newContents = $this->nonPhpFileClassRenamer->renameClasses($oldContents, $classRenames);
        // nothing has changed
        if ($oldContents === $newContents) {
            return null;
        }
        return new \Rector\Core\ValueObject\NonPhpFile\NonPhpFileChange($oldContents, $newContents);
    }
    public function supports(\RectorPrefix20210410\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        return \in_array($smartFileInfo->getExtension(), $this->getSupportedFileExtensions(), \true);
    }
    public function getSupportedFileExtensions() : array
    {
        return \Rector\Core\ValueObject\StaticNonPhpFileSuffixes::SUFFIXES;
    }
}
