<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Parser;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt;
use _PhpScoper0a6b37af0871\PhpParser\Parser as NikicParser;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Parser $nikicParser, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->nikicParser = $nikicParser;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @return Node[]
     */
    public function parseFileInfo(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : array
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
