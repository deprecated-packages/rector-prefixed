<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Dependency;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\NodeTraverser;
use _PhpScoper0a2ac50786fa\PhpParser\NodeVisitorAbstract;
class ExportedNodeVisitor extends \_PhpScoper0a2ac50786fa\PhpParser\NodeVisitorAbstract
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
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Dependency\ExportedNodeResolver $exportedNodeResolver)
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
    public function enterNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?int
    {
        if ($this->fileName === null) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
        }
        $exportedNode = $this->exportedNodeResolver->resolve($this->fileName, $node);
        if ($exportedNode !== null) {
            $this->currentNodes[] = $exportedNode;
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_ || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Trait_) {
            return \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
        return null;
    }
}
