<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer;

use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\NodeTypeResolver\PhpDocNodeVisitor\ClassRenamePhpDocNodeVisitor;
use RectorPrefix20210406\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
final class DocBlockClassRenamer
{
    /**
     * @var ClassRenamePhpDocNodeVisitor
     */
    private $classRenamePhpDocNodeVisitor;
    public function __construct(\Rector\NodeTypeResolver\PhpDocNodeVisitor\ClassRenamePhpDocNodeVisitor $classRenamePhpDocNodeVisitor)
    {
        $this->classRenamePhpDocNodeVisitor = $classRenamePhpDocNodeVisitor;
    }
    /**
     * @param array<string, string> $oldToNewClasses
     */
    public function renamePhpDocType(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, array $oldToNewClasses) : void
    {
        if ($oldToNewClasses === []) {
            return;
        }
        $phpDocNodeTraverser = new \RectorPrefix20210406\Symplify\SimplePhpDocParser\PhpDocNodeTraverser();
        $this->classRenamePhpDocNodeVisitor->setOldToNewClasses($oldToNewClasses);
        $phpDocNodeTraverser->addPhpDocNodeVisitor($this->classRenamePhpDocNodeVisitor);
        $phpDocNodeTraverser->traverse($phpDocInfo->getPhpDocNode());
    }
}
