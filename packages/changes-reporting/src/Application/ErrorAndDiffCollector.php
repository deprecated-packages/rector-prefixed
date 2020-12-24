<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\ChangesReporting\Application;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\AnalysedCodeException;
use _PhpScoper0a6b37af0871\Rector\ChangesReporting\Collector\RectorChangeCollector;
use _PhpScoper0a6b37af0871\Rector\ConsoleDiffer\DifferAndFormatter;
use _PhpScoper0a6b37af0871\Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector;
use _PhpScoper0a6b37af0871\Rector\Core\Error\ExceptionCorrector;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\Application\RectorError;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\Reporting\FileDiff;
use _PhpScoper0a6b37af0871\Rector\PostRector\Collector\NodesToRemoveCollector;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
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
     * @var DifferAndFormatter
     */
    private $differAndFormatter;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\ConsoleDiffer\DifferAndFormatter $differAndFormatter, \_PhpScoper0a6b37af0871\Rector\Core\Error\ExceptionCorrector $exceptionCorrector, \_PhpScoper0a6b37af0871\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \_PhpScoper0a6b37af0871\Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector, \_PhpScoper0a6b37af0871\Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector $removedAndAddedFilesCollector)
    {
        $this->differAndFormatter = $differAndFormatter;
        $this->rectorChangeCollector = $rectorChangeCollector;
        $this->exceptionCorrector = $exceptionCorrector;
        $this->removedAndAddedFilesCollector = $removedAndAddedFilesCollector;
        $this->nodesToRemoveCollector = $nodesToRemoveCollector;
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
    public function addFileDiff(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, string $newContent, string $oldContent) : void
    {
        if ($newContent === $oldContent) {
            return;
        }
        $rectorChanges = $this->rectorChangeCollector->getRectorChangesByFileInfo($smartFileInfo);
        // always keep the most recent diff
        $this->fileDiffs[$smartFileInfo->getRealPath()] = new \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\Reporting\FileDiff($smartFileInfo, $this->differAndFormatter->diff($oldContent, $newContent), $this->differAndFormatter->diffAndFormat($oldContent, $newContent), $rectorChanges);
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
    public function addAutoloadError(\_PhpScoper0a6b37af0871\PHPStan\AnalysedCodeException $analysedCodeException, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $message = $this->exceptionCorrector->getAutoloadExceptionMessageAndAddLocation($analysedCodeException);
        $this->errors[] = new \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\Application\RectorError($fileInfo, $message);
    }
    public function addErrorWithRectorClassMessageAndFileInfo(string $rectorClass, string $message, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->errors[] = new \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\Application\RectorError($smartFileInfo, $message, null, $rectorClass);
    }
    public function addThrowableWithFileInfo(\Throwable $throwable, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $rectorClass = $this->exceptionCorrector->matchRectorClass($throwable);
        if ($rectorClass) {
            $this->addErrorWithRectorClassMessageAndFileInfo($rectorClass, $throwable->getMessage(), $fileInfo);
        } else {
            $this->errors[] = new \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\Application\RectorError($fileInfo, $throwable->getMessage(), $throwable->getCode());
        }
    }
}
