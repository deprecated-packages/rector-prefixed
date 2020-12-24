<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Matcher;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
final class PropertyAssignMatcher
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * Covers:
     * - $this->propertyName = $expr;
     * - $this->propertyName[] = $expr;
     */
    public function matchPropertyAssignExpr(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign $assign, string $propertyName) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        if ($this->isPropertyFetch($assign->var)) {
            if (!$this->nodeNameResolver->isName($assign->var, $propertyName)) {
                return null;
            }
            return $assign->expr;
        }
        if ($assign->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch && $this->isPropertyFetch($assign->var->var)) {
            if (!$this->nodeNameResolver->isName($assign->var->var, $propertyName)) {
                return null;
            }
            return $assign->expr;
        }
        return null;
    }
    private function isPropertyFetch(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch) {
            return \true;
        }
        return $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticPropertyFetch;
    }
}
