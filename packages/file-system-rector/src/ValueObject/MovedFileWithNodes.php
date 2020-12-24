<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\FileSystemRector\Contract\MovedFileInterface;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class MovedFileWithNodes implements \_PhpScoperb75b35f52b74\Rector\FileSystemRector\Contract\MovedFileInterface
{
    /**
     * @var string
     */
    private $filePath;
    /**
     * @var Node[]
     */
    private $nodes = [];
    /**
     * @var SmartFileInfo
     */
    private $originalSmartFileInfo;
    /**
     * @var string|null
     */
    private $oldClassName;
    /**
     * @var string|null
     */
    private $newClassName;
    /**
     * @param Node[] $nodes
     */
    public function __construct(array $nodes, string $fileDestination, \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $originalSmartFileInfo, ?string $oldClassName = null, ?string $newClassName = null)
    {
        $this->nodes = $nodes;
        $this->filePath = $fileDestination;
        $this->oldClassName = $oldClassName;
        $this->newClassName = $newClassName;
        $this->originalSmartFileInfo = $originalSmartFileInfo;
    }
    /**
     * @return Node[]
     */
    public function getNodes() : array
    {
        return $this->nodes;
    }
    public function getNewPathname() : string
    {
        return $this->filePath;
    }
    public function getOldClassName() : string
    {
        if ($this->oldClassName === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $this->oldClassName;
    }
    public function getNewClassName() : string
    {
        if ($this->newClassName === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $this->newClassName;
    }
    public function hasClassRename() : bool
    {
        return $this->newClassName !== null;
    }
    public function getOriginalFileInfo() : \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->originalSmartFileInfo;
    }
    public function getOldPathname() : string
    {
        return $this->originalSmartFileInfo->getPathname();
    }
}
