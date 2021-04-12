<?php

declare (strict_types=1);
namespace Rector\Core\ValueObjectFactory;

use Rector\ChangesReporting\Application\ErrorAndDiffCollector;
use Rector\Core\ValueObject\Application\File;
use Rector\Core\ValueObject\ProcessResult;
final class ProcessResultFactory
{
    /**
     * @var ErrorAndDiffCollector
     */
    private $errorAndDiffCollector;
    public function __construct(\Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector)
    {
        $this->errorAndDiffCollector = $errorAndDiffCollector;
    }
    /**
     * @param File[] $files
     */
    public function create(array $files) : \Rector\Core\ValueObject\ProcessResult
    {
        $fileDiffs = [];
        foreach ($files as $file) {
            if ($file->getFileDiff() === null) {
                continue;
            }
            $fileDiffs[] = $file->getFileDiff();
        }
        return new \Rector\Core\ValueObject\ProcessResult($fileDiffs, $this->errorAndDiffCollector->getErrors(), $this->errorAndDiffCollector->getAddedFilesCount(), $this->errorAndDiffCollector->getRemovedFilesCount(), $this->errorAndDiffCollector->getRemovedNodeCount());
    }
}
