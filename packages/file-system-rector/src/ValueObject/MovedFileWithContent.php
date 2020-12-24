<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject;

use _PhpScoper0a6b37af0871\Rector\FileSystemRector\Contract\MovedFileInterface;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class MovedFileWithContent implements \_PhpScoper0a6b37af0871\Rector\FileSystemRector\Contract\MovedFileInterface
{
    /**
     * @var string
     */
    private $newPathname;
    /**
     * @var string
     */
    private $fileContent;
    /**
     * @var SmartFileInfo
     */
    private $oldFileInfo;
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $oldFileInfo, string $newPathname)
    {
        $this->oldFileInfo = $oldFileInfo;
        $this->newPathname = $newPathname;
        $this->fileContent = $oldFileInfo->getContents();
    }
    public function getOldPathname() : string
    {
        return $this->oldFileInfo->getPathname();
    }
    public function getNewPathname() : string
    {
        return $this->newPathname;
    }
    public function getFileContent() : string
    {
        return $this->fileContent;
    }
}
