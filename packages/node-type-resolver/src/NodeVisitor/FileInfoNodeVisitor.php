<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeVisitor;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class FileInfoNodeVisitor extends \_PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract
{
    /**
     * @var CurrentFileInfoProvider
     */
    private $currentFileInfoProvider;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider $currentFileInfoProvider)
    {
        $this->currentFileInfoProvider = $currentFileInfoProvider;
    }
    public function enterNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $node->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO, $this->currentFileInfoProvider->getSmartFileInfo());
        return $node;
    }
}
