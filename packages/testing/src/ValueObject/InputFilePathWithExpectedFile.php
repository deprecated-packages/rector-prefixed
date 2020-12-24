<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Testing\ValueObject;

use _PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(string $inputFilePath, \_PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\AddedFileWithContent $addedFileWithContent)
    {
        $this->inputFilePath = $inputFilePath;
        $this->addedFileWithContent = $addedFileWithContent;
    }
    public function getInputFileInfo() : \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo($this->inputFilePath);
    }
    public function getAddedFileWithContent() : \_PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\AddedFileWithContent
    {
        return $this->addedFileWithContent;
    }
}
