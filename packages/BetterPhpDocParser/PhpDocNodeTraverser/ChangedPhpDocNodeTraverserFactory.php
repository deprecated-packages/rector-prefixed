<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocNodeTraverser;

use Rector\BetterPhpDocParser\PhpDocNodeVisitor\ChangedPhpDocNodeVisitor;
use RectorPrefix20210503\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
final class ChangedPhpDocNodeTraverserFactory
{
    /**
     * @var ChangedPhpDocNodeVisitor
     */
    private $changedPhpDocNodeVisitor;
    public function __construct(\Rector\BetterPhpDocParser\PhpDocNodeVisitor\ChangedPhpDocNodeVisitor $changedPhpDocNodeVisitor)
    {
        $this->changedPhpDocNodeVisitor = $changedPhpDocNodeVisitor;
    }
    public function create() : \RectorPrefix20210503\Symplify\SimplePhpDocParser\PhpDocNodeTraverser
    {
        $changedPhpDocNodeTraverser = new \RectorPrefix20210503\Symplify\SimplePhpDocParser\PhpDocNodeTraverser();
        $changedPhpDocNodeTraverser->addPhpDocNodeVisitor($this->changedPhpDocNodeVisitor);
        return $changedPhpDocNodeTraverser;
    }
}
