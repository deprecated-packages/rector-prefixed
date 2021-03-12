<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\FormControlTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\ValueObject\MethodName;
use Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
use Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
use Rector\NodeNameResolver\NodeNameResolver;
final class ClassMethodFormTypeResolver implements \Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface, \Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\PhpParser\Node $node) : array
    {
        if (!$node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return [];
        }
        if ($this->nodeNameResolver->isName($node, \Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return [];
        }
        $lastReturn = $this->betterNodeFinder->findLastInstanceOf((array) $node->stmts, \PhpParser\Node\Stmt\Return_::class);
        if (!$lastReturn instanceof \PhpParser\Node\Stmt\Return_) {
            return [];
        }
        if (!$lastReturn->expr instanceof \PhpParser\Node\Expr\Variable) {
            return [];
        }
        return $this->methodNamesByInputNamesResolver->resolveExpr($lastReturn->expr);
    }
    public function setResolver(\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver) : void
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
}
