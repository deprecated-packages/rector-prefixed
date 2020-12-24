<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\NodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
final class StaticCallAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isParentCallNamed(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $desiredMethodName) : bool
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        if ($node->class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node->class, 'parent')) {
            return \false;
        }
        if ($node->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr) {
            return \false;
        }
        return $this->nodeNameResolver->isName($node->name, $desiredMethodName);
    }
}
