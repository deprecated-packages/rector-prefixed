<?php

declare(strict_types=1);

namespace Rector\Core\ValueObject;

use Rector\Core\ValueObject\Application\RectorError;
use Rector\Core\ValueObject\Reporting\FileDiff;
use Symplify\SmartFileSystem\SmartFileInfo;
use Webmozart\Assert\Assert;

/**
 * @see \Rector\Core\ValueObjectFactory\ProcessResultFactory
 */
final class ProcessResult
{
    /**
     * @var FileDiff[]
     */
    private $fileDiffs = [];

    /**
     * @var RectorError[]
     */
    private $errors = [];

    /**
     * @var int
     */
    private $addedFilesCount;

    /**
     * @var int
     */
    private $removedFilesCount;

    /**
     * @var int
     */
    private $removedNodeCount;

    /**
     * @param FileDiff[] $fileDiffs
     * @param RectorError[] $errors
     */
    public function __construct(
        array $fileDiffs,
        array $errors,
        int $addedFilesCount,
        int $removedFilesCount,
        int $removedNodeCount
    ) {
        Assert::allIsAOf($fileDiffs, FileDiff::class);
        Assert::allIsAOf($errors, RectorError::class);

        $this->fileDiffs = $fileDiffs;
        $this->errors = $errors;
        $this->addedFilesCount = $addedFilesCount;
        $this->removedFilesCount = $removedFilesCount;
        $this->removedNodeCount = $removedNodeCount;
    }

    /**
     * @return FileDiff[]
     */
    public function getFileDiffs(): array
    {
        return $this->fileDiffs;
    }

    /**
     * @return RectorError[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getAddedFilesCount(): int
    {
        return $this->addedFilesCount;
    }

    public function getRemovedFilesCount(): int
    {
        return $this->removedFilesCount;
    }

    public function getRemovedAndAddedFilesCount(): int
    {
        return $this->removedFilesCount + $this->addedFilesCount;
    }

    public function getRemovedNodeCount(): int
    {
        return $this->removedNodeCount;
    }

    /**
     * @return SmartFileInfo[]
     */
    public function getChangedFileInfos(): array
    {
        $fileInfos = [];
        foreach ($this->fileDiffs as $fileDiff) {
            $fileInfos[] = $fileDiff->getFileInfo();
        }

        return array_unique($fileInfos);
    }
}
