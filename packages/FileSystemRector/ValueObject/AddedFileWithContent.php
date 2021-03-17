<?php

declare (strict_types=1);
namespace Rector\FileSystemRector\ValueObject;

use Rector\FileSystemRector\Contract\AddedFileInterface;
final class AddedFileWithContent implements \Rector\FileSystemRector\Contract\AddedFileInterface
{
    /**
     * @var string
     */
    private $filePath;
    /**
     * @var string
     */
    private $fileContent;
    /**
     * @param string $filePath
     * @param string $fileContent
     */
    public function __construct($filePath, $fileContent)
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
