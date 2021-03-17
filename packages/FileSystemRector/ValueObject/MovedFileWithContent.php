<?php

declare (strict_types=1);
namespace Rector\FileSystemRector\ValueObject;

use Rector\FileSystemRector\Contract\MovedFileInterface;
use RectorPrefix20210317\Symplify\SmartFileSystem\SmartFileInfo;
final class MovedFileWithContent implements \Rector\FileSystemRector\Contract\MovedFileInterface
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
    /**
     * @param \Symplify\SmartFileSystem\SmartFileInfo $oldFileInfo
     * @param string $newPathname
     */
    public function __construct($oldFileInfo, $newPathname)
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
