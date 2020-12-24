<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeVisitor;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class FileInfoNodeVisitor extends \_PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract
{
    /**
     * @var CurrentFileInfoProvider
     */
    private $currentFileInfoProvider;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider $currentFileInfoProvider)
    {
        $this->currentFileInfoProvider = $currentFileInfoProvider;
    }
    public function enterNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO, $this->currentFileInfoProvider->getSmartFileInfo());
        return $node;
    }
}
