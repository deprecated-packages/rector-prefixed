<?php

declare(strict_types=1);

namespace Rector\NodeTypeResolver\PhpDoc;

use PhpParser\Node;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\NodeTypeResolver\PhpDocNodeVisitor\UnderscoreRenamePhpDocNodeVisitor;
use Rector\Renaming\ValueObject\PseudoNamespaceToNamespace;
use Symplify\SimplePhpDocParser\PhpDocNodeTraverser;

final class PhpDocTypeRenamer
{
    /**
     * @var UnderscoreRenamePhpDocNodeVisitor
     */
    private $underscoreRenamePhpDocNodeVisitor;

    public function __construct(UnderscoreRenamePhpDocNodeVisitor $underscoreRenamePhpDocNodeVisitor)
    {
        $this->underscoreRenamePhpDocNodeVisitor = $underscoreRenamePhpDocNodeVisitor;
    }

    /**
     * @return void
     */
    public function changeUnderscoreType(
        PhpDocInfo $phpDocInfo,
        Node $node,
        PseudoNamespaceToNamespace $pseudoNamespaceToNamespace
    ) {
        $phpDocNode = $phpDocInfo->getPhpDocNode();

        $phpDocNodeTraverser = new PhpDocNodeTraverser();
        $this->underscoreRenamePhpDocNodeVisitor->setPseudoNamespaceToNamespace($pseudoNamespaceToNamespace);
        $this->underscoreRenamePhpDocNodeVisitor->setCurrentPhpParserNode($node);

        $phpDocNodeTraverser->addPhpDocNodeVisitor($this->underscoreRenamePhpDocNodeVisitor);
        $phpDocNodeTraverser->traverse($phpDocNode);
    }
}
