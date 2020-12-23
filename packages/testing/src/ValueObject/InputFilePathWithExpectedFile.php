<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Testing\ValueObject;

use _PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(string $inputFilePath, \_PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\AddedFileWithContent $addedFileWithContent)
    {
        $this->inputFilePath = $inputFilePath;
        $this->addedFileWithContent = $addedFileWithContent;
    }
    public function getInputFileInfo() : \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo($this->inputFilePath);
    }
    public function getAddedFileWithContent() : \_PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\AddedFileWithContent
    {
        return $this->addedFileWithContent;
    }
}
