<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\NodeVisitor;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
final class PhpDocInfoNodeVisitor extends \PhpParser\NodeVisitorAbstract
{
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    public function enterNode(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        // also binds to the node
        $this->phpDocInfoFactory->createFromNode($node);
        return $node;
    }
}
