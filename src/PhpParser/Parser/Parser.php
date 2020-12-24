<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Parser;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Parser as NikicParser;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
final class Parser
{
    /**
     * @var Stmt[][]
     */
    private $nodesByFile = [];
    /**
     * @var NikicParser
     */
    private $nikicParser;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Parser $nikicParser, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->nikicParser = $nikicParser;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @return Node[]
     */
    public function parseFileInfo(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : array
    {
        $fileRealPath = $smartFileInfo->getRealPath();
        if (isset($this->nodesByFile[$fileRealPath])) {
            return $this->nodesByFile[$fileRealPath];
        }
        $fileContent = $this->smartFileSystem->readFile($fileRealPath);
        $this->nodesByFile[$fileRealPath] = (array) $this->nikicParser->parse($fileContent);
        return $this->nodesByFile[$fileRealPath];
    }
}
