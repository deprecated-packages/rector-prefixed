<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Parser;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use PhpParser\Parser as NikicParser;
use RectorPrefix20210130\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210130\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\PhpParser\Parser $nikicParser, \RectorPrefix20210130\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->nikicParser = $nikicParser;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @return Node[]
     */
    public function parseFileInfo(\RectorPrefix20210130\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : array
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
