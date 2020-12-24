<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\FileSystemRector\Parser;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Parser\Parser;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class FileInfoParser
{
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var NodeScopeAndMetadataDecorator
     */
    private $nodeScopeAndMetadataDecorator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator $nodeScopeAndMetadataDecorator, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Parser\Parser $parser)
    {
        $this->parser = $parser;
        $this->nodeScopeAndMetadataDecorator = $nodeScopeAndMetadataDecorator;
    }
    /**
     * @return Node[]
     */
    public function parseFileInfoToNodesAndDecorate(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : array
    {
        $oldStmts = $this->parser->parseFileInfo($fileInfo);
        return $this->nodeScopeAndMetadataDecorator->decorateNodesFromFile($oldStmts, $fileInfo);
    }
    /**
     * @return Node[]
     */
    public function parseFileInfoToNodesAndDecorateWithScope(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : array
    {
        $oldStmts = $this->parser->parseFileInfo($fileInfo);
        return $this->nodeScopeAndMetadataDecorator->decorateNodesFromFile($oldStmts, $fileInfo, \true);
    }
}
