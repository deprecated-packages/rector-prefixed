<?php

declare (strict_types=1);
namespace Rector\Core\ValueObject\Application;

use PhpParser\Node\Stmt;
use Rector\ChangesReporting\ValueObject\RectorWithLineChange;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\ValueObject\Reporting\FileDiff;
use RectorPrefix20210421\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\Core\ValueObjectFactory\Application\FileFactory
 */
final class File
{
    /**
     * @var SmartFileInfo
     */
    private $smartFileInfo;
    /**
     * @var string
     */
    private $fileContent;
    /**
     * @var bool
     */
    private $hasChanged = \false;
    /**
     * @var string
     */
    private $originalFileContent;
    /**
     * @var FileDiff|null
     */
    private $fileDiff;
    /**
     * @var Stmt[]
     */
    private $oldStmts = [];
    /**
     * @var Stmt[]
     */
    private $newStmts = [];
    /**
     * @var mixed[]
     */
    private $oldTokens = [];
    /**
     * @var RectorWithLineChange[]
     */
    private $rectorWithLineChanges = [];
    /**
     * @var RectorError[]
     */
    private $rectorErrors = [];
    public function __construct(\RectorPrefix20210421\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, string $fileContent)
    {
        $this->smartFileInfo = $smartFileInfo;
        $this->fileContent = $fileContent;
        $this->originalFileContent = $fileContent;
    }
    public function getSmartFileInfo() : \RectorPrefix20210421\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->smartFileInfo;
    }
    public function getFileContent() : string
    {
        return $this->fileContent;
    }
    /**
     * @return void
     */
    public function changeFileContent(string $newFileContent)
    {
        if ($this->fileContent === $newFileContent) {
            return;
        }
        $this->fileContent = $newFileContent;
        $this->hasChanged = \true;
    }
    public function getOriginalFileContent() : string
    {
        return $this->originalFileContent;
    }
    public function hasChanged() : bool
    {
        return $this->hasChanged;
    }
    /**
     * @return void
     */
    public function setFileDiff(\Rector\Core\ValueObject\Reporting\FileDiff $fileDiff)
    {
        $this->fileDiff = $fileDiff;
    }
    /**
     * @return \Rector\Core\ValueObject\Reporting\FileDiff|null
     */
    public function getFileDiff()
    {
        return $this->fileDiff;
    }
    /**
     * @param Stmt[] $newStmts
     * @param Stmt[] $oldStmts
     * @param mixed[] $oldTokens
     * @return void
     */
    public function hydrateStmtsAndTokens(array $newStmts, array $oldStmts, array $oldTokens)
    {
        if ($this->oldStmts !== []) {
            throw new \Rector\Core\Exception\ShouldNotHappenException('Double stmts override');
        }
        $this->oldStmts = $oldStmts;
        $this->newStmts = $newStmts;
        $this->oldTokens = $oldTokens;
    }
    /**
     * @return Stmt[]
     */
    public function getOldStmts() : array
    {
        return $this->oldStmts;
    }
    /**
     * @return Stmt[]
     */
    public function getNewStmts() : array
    {
        return $this->newStmts;
    }
    /**
     * @return mixed[]
     */
    public function getOldTokens() : array
    {
        return $this->oldTokens;
    }
    /**
     * @param Stmt[] $newStmts
     * @return void
     */
    public function changeNewStmts(array $newStmts)
    {
        $this->newStmts = $newStmts;
    }
    /**
     * @return void
     */
    public function addRectorClassWithLine(\Rector\ChangesReporting\ValueObject\RectorWithLineChange $rectorWithLineChange)
    {
        $this->rectorWithLineChanges[] = $rectorWithLineChange;
    }
    /**
     * @return RectorWithLineChange[]
     */
    public function getRectorWithLineChanges() : array
    {
        return $this->rectorWithLineChanges;
    }
    /**
     * @return void
     */
    public function addRectorError(\Rector\Core\ValueObject\Application\RectorError $rectorError)
    {
        $this->rectorErrors[] = $rectorError;
    }
    public function hasErrors() : bool
    {
        return $this->rectorErrors !== [];
    }
    /**
     * @return RectorError[]
     */
    public function getErrors() : array
    {
        return $this->rectorErrors;
    }
}
