<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\FileSystemRector\Parser;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Parser\Parser;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator $nodeScopeAndMetadataDecorator, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Parser\Parser $parser)
    {
        $this->parser = $parser;
        $this->nodeScopeAndMetadataDecorator = $nodeScopeAndMetadataDecorator;
    }
    /**
     * @return Node[]
     */
    public function parseFileInfoToNodesAndDecorate(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : array
    {
        $oldStmts = $this->parser->parseFileInfo($fileInfo);
        return $this->nodeScopeAndMetadataDecorator->decorateNodesFromFile($oldStmts, $fileInfo);
    }
    /**
     * @return Node[]
     */
    public function parseFileInfoToNodesAndDecorateWithScope(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : array
    {
        $oldStmts = $this->parser->parseFileInfo($fileInfo);
        return $this->nodeScopeAndMetadataDecorator->decorateNodesFromFile($oldStmts, $fileInfo, \true);
    }
}
