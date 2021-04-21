<?php

declare (strict_types=1);
namespace Rector\FileSystemRector\ValueObject;

use Rector\Core\Exception\ShouldNotHappenException;
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
    public function __construct(string $filePath, string $fileContent)
    {
        if ($filePath === $fileContent) {
            throw new \Rector\Core\Exception\ShouldNotHappenException('File path and content are the same, probably a bug');
        }
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
