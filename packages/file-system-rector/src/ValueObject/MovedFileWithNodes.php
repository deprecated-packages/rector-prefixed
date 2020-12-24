<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\ValueObject;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\Contract\MovedFileInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class MovedFileWithNodes implements \_PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\Contract\MovedFileInterface
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
    public function __construct(array $nodes, string $fileDestination, \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $originalSmartFileInfo, ?string $oldClassName = null, ?string $newClassName = null)
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
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $this->oldClassName;
    }
    public function getNewClassName() : string
    {
        if ($this->newClassName === null) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $this->newClassName;
    }
    public function hasClassRename() : bool
    {
        return $this->newClassName !== null;
    }
    public function getOriginalFileInfo() : \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->originalSmartFileInfo;
    }
    public function getOldPathname() : string
    {
        return $this->originalSmartFileInfo->getPathname();
    }
}
