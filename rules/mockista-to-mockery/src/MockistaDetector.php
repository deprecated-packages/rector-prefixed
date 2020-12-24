<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\MockistaToMockery;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
final class MockistaDetector
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isInClass(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $class->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
                return \false;
            }
            return $this->nodeNameResolver->isName($node, 'mock');
        });
    }
}
