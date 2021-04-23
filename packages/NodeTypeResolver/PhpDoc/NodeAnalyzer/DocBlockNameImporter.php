<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer;

use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use Rector\NodeTypeResolver\PhpDocNodeVisitor\NameImportingPhpDocNodeVisitor;
use RectorPrefix20210423\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
final class DocBlockNameImporter
{
    /**
     * @var NameImportingPhpDocNodeVisitor
     */
    private $nameImportingPhpDocNodeVisitor;
    public function __construct(\Rector\NodeTypeResolver\PhpDocNodeVisitor\NameImportingPhpDocNodeVisitor $nameImportingPhpDocNodeVisitor)
    {
        $this->nameImportingPhpDocNodeVisitor = $nameImportingPhpDocNodeVisitor;
    }
    /**
     * @return void
     */
    public function importNames(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \PhpParser\Node $node)
    {
        if ($phpDocNode->children === []) {
            return;
        }
        $phpDocNodeTraverser = new \RectorPrefix20210423\Symplify\SimplePhpDocParser\PhpDocNodeTraverser();
        $this->nameImportingPhpDocNodeVisitor->setCurrentNode($node);
        $phpDocNodeTraverser->addPhpDocNodeVisitor($this->nameImportingPhpDocNodeVisitor);
        $phpDocNodeTraverser->traverse($phpDocNode);
    }
}
