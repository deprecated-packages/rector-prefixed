<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Testing\ValueObject;

use _PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class InputFilePathWithExpectedFile
{
    /**
     * @var string
     */
    private $inputFilePath;
    /**
     * @var AddedFileWithContent
     */
    private $addedFileWithContent;
    public function __construct(string $inputFilePath, \_PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\AddedFileWithContent $addedFileWithContent)
    {
        $this->inputFilePath = $inputFilePath;
        $this->addedFileWithContent = $addedFileWithContent;
    }
    public function getInputFileInfo() : \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo($this->inputFilePath);
    }
    public function getAddedFileWithContent() : \_PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\AddedFileWithContent
    {
        return $this->addedFileWithContent;
    }
}
