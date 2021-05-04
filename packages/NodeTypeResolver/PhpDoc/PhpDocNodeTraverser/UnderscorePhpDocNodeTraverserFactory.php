<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\PhpDoc\PhpDocNodeTraverser;

use Rector\NodeTypeResolver\PhpDocNodeVisitor\UnderscoreRenamePhpDocNodeVisitor;
use RectorPrefix20210504\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
final class UnderscorePhpDocNodeTraverserFactory
{
    /**
     * @var UnderscoreRenamePhpDocNodeVisitor
     */
    private $underscoreRenamePhpDocNodeVisitor;
    public function __construct(\Rector\NodeTypeResolver\PhpDocNodeVisitor\UnderscoreRenamePhpDocNodeVisitor $underscoreRenamePhpDocNodeVisitor)
    {
        $this->underscoreRenamePhpDocNodeVisitor = $underscoreRenamePhpDocNodeVisitor;
    }
    public function create() : \RectorPrefix20210504\Symplify\SimplePhpDocParser\PhpDocNodeTraverser
    {
        $phpDocNodeTraverser = new \RectorPrefix20210504\Symplify\SimplePhpDocParser\PhpDocNodeTraverser();
        $phpDocNodeTraverser->addPhpDocNodeVisitor($this->underscoreRenamePhpDocNodeVisitor);
        return $phpDocNodeTraverser;
    }
}
