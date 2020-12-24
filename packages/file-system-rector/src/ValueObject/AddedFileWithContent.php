<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject;

final class AddedFileWithContent
{
    /**
     * @var string
     */
    private $filePath;
    /**
     * @var string
     */
    private $fileContent;
    public function __construct(string $filePath, string $fileContent)
    {
        $this->filePath = $filePath;
        $this->fileContent = $fileContent;
    }
    public function getFilePath() : string
    {
        return $this->filePath;
    }
    public function getFileContent() : string
    {
        return $this->fileContent;
    }
}
