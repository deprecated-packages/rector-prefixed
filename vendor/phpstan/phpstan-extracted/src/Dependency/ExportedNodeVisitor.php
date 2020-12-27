<?php

declare (strict_types=1);
namespace PHPStan\Dependency;

use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
class ExportedNodeVisitor extends \PhpParser\NodeVisitorAbstract
{
    /** @var ExportedNodeResolver */
    private $exportedNodeResolver;
    /** @var string|null */
    private $fileName = null;
    /** @var ExportedNode[] */
    private $currentNodes = [];
    /**
     * ExportedNodeVisitor constructor.
     *
     * @param ExportedNodeResolver $exportedNodeResolver
     */
    public function __construct(\PHPStan\Dependency\ExportedNodeResolver $exportedNodeResolver)
    {
        $this->exportedNodeResolver = $exportedNodeResolver;
    }
    public function reset(string $fileName) : void
    {
        $this->fileName = $fileName;
        $this->currentNodes = [];
    }
    /**
     * @return ExportedNode[]
     */
    public function getExportedNodes() : array
    {
        return $this->currentNodes;
    }
    public function enterNode(\PhpParser\Node $node) : ?int
    {
        if ($this->fileName === null) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        $exportedNode = $this->exportedNodeResolver->resolve($this->fileName, $node);
        if ($exportedNode !== null) {
            $this->currentNodes[] = $exportedNode;
        }
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod || $node instanceof \PhpParser\Node\Stmt\Function_ || $node instanceof \PhpParser\Node\Stmt\Trait_) {
            return \PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
        return null;
    }
}
