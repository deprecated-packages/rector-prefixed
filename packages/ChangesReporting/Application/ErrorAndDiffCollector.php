<?php

declare (strict_types=1);
namespace Rector\ChangesReporting\Application;

use PhpParser\Node;
use PHPStan\AnalysedCodeException;
use Rector\ChangesReporting\Collector\RectorChangeCollector;
use Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector;
use Rector\Core\Differ\DefaultDiffer;
use Rector\Core\Error\ExceptionCorrector;
use Rector\Core\ValueObject\Application\RectorError;
use Rector\Core\ValueObject\Reporting\FileDiff;
use Rector\PostRector\Collector\NodesToRemoveCollector;
use RectorPrefix20210408\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
use Throwable;
final class ErrorAndDiffCollector
{
    /**
     * @var RectorError[]
     */
    private $errors = [];
    /**
     * @var FileDiff[]
     */
    private $fileDiffs = [];
    /**
     * @var RectorChangeCollector
     */
    private $rectorChangeCollector;
    /**
     * @var ExceptionCorrector
     */
    private $exceptionCorrector;
    /**
     * @var RemovedAndAddedFilesCollector
     */
    private $removedAndAddedFilesCollector;
    /**
     * @var NodesToRemoveCollector
     */
    private $nodesToRemoveCollector;
    /**
     * @var ConsoleDiffer
     */
    private $consoleDiffer;
    /**
     * @var DefaultDiffer
     */
    private $defaultDiffer;
    public function __construct(\Rector\Core\Error\ExceptionCorrector $exceptionCorrector, \Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector, \Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector $removedAndAddedFilesCollector, \RectorPrefix20210408\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer $consoleDiffer, \Rector\Core\Differ\DefaultDiffer $defaultDiffer)
    {
        $this->rectorChangeCollector = $rectorChangeCollector;
        $this->exceptionCorrector = $exceptionCorrector;
        $this->removedAndAddedFilesCollector = $removedAndAddedFilesCollector;
        $this->nodesToRemoveCollector = $nodesToRemoveCollector;
        $this->consoleDiffer = $consoleDiffer;
        $this->defaultDiffer = $defaultDiffer;
    }
    /**
     * @return RectorError[]
     */
    public function getErrors() : array
    {
        return $this->errors;
    }
    public function getRemovedAndAddedFilesCount() : int
    {
        return $this->removedAndAddedFilesCollector->getAffectedFilesCount();
    }
    public function getAddFilesCount() : int
    {
        return $this->removedAndAddedFilesCollector->getAddedFileCount();
    }
    public function getRemovedFilesCount() : int
    {
        return $this->removedAndAddedFilesCollector->getRemovedFilesCount();
    }
    public function getRemovedNodeCount() : int
    {
        return $this->nodesToRemoveCollector->getCount();
    }
    /**
     * @return Node[]
     */
    public function getRemovedNodes() : array
    {
        return $this->nodesToRemoveCollector->getNodesToRemove();
    }
    public function addFileDiff(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, string $newContent, string $oldContent) : void
    {
        if ($newContent === $oldContent) {
            return;
        }
        $rectorChanges = $this->rectorChangeCollector->getRectorChangesByFileInfo($smartFileInfo);
        // always keep the most recent diff
        $fileDiff = new \Rector\Core\ValueObject\Reporting\FileDiff($smartFileInfo, $this->defaultDiffer->diff($oldContent, $newContent), $this->consoleDiffer->diff($oldContent, $newContent), $rectorChanges);
        $this->fileDiffs[$smartFileInfo->getRealPath()] = $fileDiff;
    }
    /**
     * @return FileDiff[]
     */
    public function getFileDiffs() : array
    {
        return $this->fileDiffs;
    }
    /**
     * @return SmartFileInfo[]
     */
    public function getAffectedFileInfos() : array
    {
        $fileInfos = [];
        foreach ($this->fileDiffs as $fileDiff) {
            $fileInfos[] = $fileDiff->getFileInfo();
        }
        return \array_unique($fileInfos);
    }
    public function getFileDiffsCount() : int
    {
        return \count($this->fileDiffs);
    }
    public function addAutoloadError(\PHPStan\AnalysedCodeException $analysedCodeException, \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $message = $this->exceptionCorrector->getAutoloadExceptionMessageAndAddLocation($analysedCodeException);
        $this->errors[] = new \Rector\Core\ValueObject\Application\RectorError($fileInfo, $message);
    }
    public function addErrorWithRectorClassMessageAndFileInfo(string $rectorClass, string $message, \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->errors[] = new \Rector\Core\ValueObject\Application\RectorError($smartFileInfo, $message, null, $rectorClass);
    }
    public function addThrowableWithFileInfo(\Throwable $throwable, \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $rectorClass = $this->exceptionCorrector->matchRectorClass($throwable);
        if ($rectorClass) {
            $this->addErrorWithRectorClassMessageAndFileInfo($rectorClass, $throwable->getMessage(), $fileInfo);
        } else {
            $this->errors[] = new \Rector\Core\ValueObject\Application\RectorError($fileInfo, $throwable->getMessage(), $throwable->getCode());
        }
    }
    public function hasErrors(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $phpFileInfo) : bool
    {
        foreach ($this->errors as $error) {
            if ($error->getFileInfo() === $phpFileInfo) {
                return \true;
            }
        }
        return \false;
    }
}
