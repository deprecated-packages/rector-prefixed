<?php

declare (strict_types=1);
namespace Rector\Core\ValueObject\Application;

use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
final class RectorError
{
    /**
     * @var string
     */
    private $message;
    /**
     * @var SmartFileInfo
     */
    private $fileInfo;
    /**
     * @var int|null
     */
    private $line;
    /**
     * @var string|null
     */
    private $rectorClass;
    public function __construct(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, string $message, ?int $line = null, ?string $rectorClass = null)
    {
        $this->fileInfo = $smartFileInfo;
        $this->message = $message;
        $this->line = $line;
        $this->rectorClass = $rectorClass;
    }
    public function getRelativeFilePath() : string
    {
        return $this->fileInfo->getRelativeFilePathFromCwd();
    }
    public function getFileInfo() : \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->fileInfo;
    }
    public function getMessage() : string
    {
        return $this->message;
    }
    public function getLine() : ?int
    {
        return $this->line;
    }
    public function getRectorClass() : ?string
    {
        return $this->rectorClass;
    }
}
