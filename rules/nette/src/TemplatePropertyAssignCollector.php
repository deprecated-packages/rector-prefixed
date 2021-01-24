<?php

declare (strict_types=1);
namespace Rector\Nette;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Nette\ValueObject\MagicTemplatePropertyCalls;
use Rector\NodeNameResolver\NodeNameResolver;
use RectorPrefix20210124\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class TemplatePropertyAssignCollector
{
    /**
     * @var Expr[]
     */
    private $templateVariables = [];
    /**
     * @var Node[]
     */
    private $nodesToRemove = [];
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var Expr|null
     */
    private $templateFileExpr;
    public function __construct(\RectorPrefix20210124\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function collectTemplateFileNameVariablesAndNodesToRemove(\PhpParser\Node\Stmt\ClassMethod $classMethod) : \Rector\Nette\ValueObject\MagicTemplatePropertyCalls
    {
        $this->templateFileExpr = null;
        $this->templateVariables = [];
        $this->nodesToRemove = [];
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\PhpParser\Node $node) : void {
            if ($node instanceof \PhpParser\Node\Expr\MethodCall) {
                $this->collectTemplateFileExpr($node);
            }
            if ($node instanceof \PhpParser\Node\Expr\Assign) {
                $this->collectVariableFromAssign($node);
            }
        });
        return new \Rector\Nette\ValueObject\MagicTemplatePropertyCalls($this->templateFileExpr, $this->templateVariables, $this->nodesToRemove);
    }
    private function collectTemplateFileExpr(\PhpParser\Node\Expr\MethodCall $methodCall) : void
    {
        if ($this->nodeNameResolver->isName($methodCall->name, 'render')) {
            if (isset($methodCall->args[0])) {
                $this->templateFileExpr = $methodCall->args[0]->value;
            }
            $this->nodesToRemove[] = $methodCall;
        }
        if ($this->nodeNameResolver->isName($methodCall->name, 'setFile')) {
            $this->templateFileExpr = $methodCall->args[0]->value;
            $this->nodesToRemove[] = $methodCall;
        }
    }
    private function collectVariableFromAssign(\PhpParser\Node\Expr\Assign $assign) : void
    {
        // $this->template = x
        if ($assign->var instanceof \PhpParser\Node\Expr\PropertyFetch) {
            if (!$this->nodeNameResolver->isName($assign->var->var, 'template')) {
                return;
            }
            $variableName = $this->nodeNameResolver->getName($assign->var);
            $this->templateVariables[$variableName] = $assign->expr;
            $this->nodesToRemove[] = $assign;
        }
        // $x = $this->template
        if (!$assign->var instanceof \PhpParser\Node\Expr\Variable) {
            return;
        }
        if (!$this->isTemplatePropertyFetch($assign->expr)) {
            return;
        }
        $this->nodesToRemove[] = $assign;
    }
    /**
     * Looks for:
     * $this->template
     */
    private function isTemplatePropertyFetch(\PhpParser\Node\Expr $expr) : bool
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
