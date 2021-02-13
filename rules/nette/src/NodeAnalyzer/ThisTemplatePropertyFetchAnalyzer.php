<?php

declare (strict_types=1);
namespace Rector\Nette\NodeAnalyzer;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use Rector\NodeNameResolver\NodeNameResolver;
final class ThisTemplatePropertyFetchAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * $this->template->someKey => "someKey"
     */
    public function matchThisTemplateKey(\PhpParser\Node\Expr $expr) : ?string
    {
        if (!$expr instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return null;
        }
        if (!$expr->var instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return null;
        }
        if (!$this->nodeNameResolver->isName($expr->var, 'template')) {
            return null;
        }
        return $this->nodeNameResolver->getName($expr->name);
    }
    /**
     * Looks for:
     * $this->template
     *
     * $template
     */
    public function isTemplatePropertyFetch(\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        if (!$expr->var instanceof \PhpParser\Node\Expr\Variable) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($expr->var, 'this')) {
            return \false;
        }
        return $this->nodeNameResolver->isName($expr->name, 'template');
    }
}
