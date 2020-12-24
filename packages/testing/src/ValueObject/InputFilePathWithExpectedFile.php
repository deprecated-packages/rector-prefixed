<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Testing\ValueObject;

use _PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(string $inputFilePath, \_PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent $addedFileWithContent)
    {
        $this->inputFilePath = $inputFilePath;
        $this->addedFileWithContent = $addedFileWithContent;
    }
    public function getInputFileInfo() : \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo($this->inputFilePath);
    }
    public function getAddedFileWithContent() : \_PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent
    {
        return $this->addedFileWithContent;
    }
}
