<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Dependency;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract;
class ExportedNodeVisitor extends \_PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract
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
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Dependency\ExportedNodeResolver $exportedNodeResolver)
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
    public function enterNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?int
    {
        if ($this->fileName === null) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        $exportedNode = $this->exportedNodeResolver->resolve($this->fileName, $node);
        if ($exportedNode !== null) {
            $this->currentNodes[] = $exportedNode;
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_ || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Trait_) {
            return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
        return null;
    }
}
