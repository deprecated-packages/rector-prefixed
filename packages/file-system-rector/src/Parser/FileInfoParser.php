<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\FileSystemRector\Parser;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Parser\Parser;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator $nodeScopeAndMetadataDecorator, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Parser\Parser $parser)
    {
        $this->parser = $parser;
        $this->nodeScopeAndMetadataDecorator = $nodeScopeAndMetadataDecorator;
    }
    /**
     * @return Node[]
     */
    public function parseFileInfoToNodesAndDecorate(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : array
    {
        $oldStmts = $this->parser->parseFileInfo($fileInfo);
        return $this->nodeScopeAndMetadataDecorator->decorateNodesFromFile($oldStmts, $fileInfo);
    }
    /**
     * @return Node[]
     */
    public function parseFileInfoToNodesAndDecorateWithScope(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : array
    {
        $oldStmts = $this->parser->parseFileInfo($fileInfo);
        return $this->nodeScopeAndMetadataDecorator->decorateNodesFromFile($oldStmts, $fileInfo, \true);
    }
}
