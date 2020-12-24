<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\FileSystemRector\Parser;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Parser\Parser;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator $nodeScopeAndMetadataDecorator, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Parser\Parser $parser)
    {
        $this->parser = $parser;
        $this->nodeScopeAndMetadataDecorator = $nodeScopeAndMetadataDecorator;
    }
    /**
     * @return Node[]
     */
    public function parseFileInfoToNodesAndDecorate(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : array
    {
        $oldStmts = $this->parser->parseFileInfo($fileInfo);
        return $this->nodeScopeAndMetadataDecorator->decorateNodesFromFile($oldStmts, $fileInfo);
    }
    /**
     * @return Node[]
     */
    public function parseFileInfoToNodesAndDecorateWithScope(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : array
    {
        $oldStmts = $this->parser->parseFileInfo($fileInfo);
        return $this->nodeScopeAndMetadataDecorator->decorateNodesFromFile($oldStmts, $fileInfo, \true);
    }
}
