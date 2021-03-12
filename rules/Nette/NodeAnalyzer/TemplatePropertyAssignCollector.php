<?php

declare (strict_types=1);
namespace Rector\Nette\NodeAnalyzer;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Else_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Nette\ValueObject\AlwaysTemplateParameterAssign;
use Rector\Nette\ValueObject\ConditionalTemplateParameterAssign;
use Rector\Nette\ValueObject\TemplateParametersAssigns;
use Rector\NodeNestingScope\ScopeNestingComparator;
use Rector\NodeNestingScope\ValueObject\ControlStructure;
final class TemplatePropertyAssignCollector
{
    /**
     * @var ScopeNestingComparator
     */
    private $scopeNestingComparator;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var ThisTemplatePropertyFetchAnalyzer
     */
    private $thisTemplatePropertyFetchAnalyzer;
    /**
     * @var Return_|null
     */
    private $lastReturn;
    /**
     * @var ReturnAnalyzer
     */
    private $returnAnalyzer;
    /**
     * @var AlwaysTemplateParameterAssign[]
     */
    private $alwaysTemplateParameterAssigns = [];
    /**
     * @var ConditionalTemplateParameterAssign[]
     */
    private $conditionalTemplateParameterAssigns = [];
    public function __construct(\Rector\NodeNestingScope\ScopeNestingComparator $scopeNestingComparator, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\Nette\NodeAnalyzer\ThisTemplatePropertyFetchAnalyzer $thisTemplatePropertyFetchAnalyzer, \Rector\Nette\NodeAnalyzer\ReturnAnalyzer $returnAnalyzer)
    {
        $this->scopeNestingComparator = $scopeNestingComparator;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->thisTemplatePropertyFetchAnalyzer = $thisTemplatePropertyFetchAnalyzer;
        $this->returnAnalyzer = $returnAnalyzer;
    }
    public function collect(\PhpParser\Node\Stmt\ClassMethod $classMethod) : \Rector\Nette\ValueObject\TemplateParametersAssigns
    {
        $this->alwaysTemplateParameterAssigns = [];
        $this->conditionalTemplateParameterAssigns = [];
        $this->lastReturn = $this->returnAnalyzer->findLastClassMethodReturn($classMethod);
        /** @var Assign[] $assigns */
        $assigns = $this->betterNodeFinder->findInstanceOf((array) $classMethod->stmts, \PhpParser\Node\Expr\Assign::class);
        foreach ($assigns as $assign) {
            $this->collectVariableFromAssign($assign);
        }
        return new \Rector\Nette\ValueObject\TemplateParametersAssigns($this->alwaysTemplateParameterAssigns, $this->conditionalTemplateParameterAssigns);
    }
    private function collectVariableFromAssign(\PhpParser\Node\Expr\Assign $assign) : void
    {
        // $this->template = x
        if (!$assign->var instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return;
        }
        $parameterName = $this->thisTemplatePropertyFetchAnalyzer->resolveTemplateParameterNameFromAssign($assign);
        if ($parameterName === null) {
            return;
        }
        $propertyFetch = $assign->var;
        $foundParent = $this->betterNodeFinder->findParentTypes($propertyFetch->var, \Rector\NodeNestingScope\ValueObject\ControlStructure::CONDITIONAL_NODE_SCOPE_TYPES + [\PhpParser\Node\FunctionLike::class]);
        if ($foundParent && $this->scopeNestingComparator->isInBothIfElseBranch($foundParent, $propertyFetch)) {
            $this->conditionalTemplateParameterAssigns[] = new \Rector\Nette\ValueObject\ConditionalTemplateParameterAssign($assign, $parameterName);
            return;
        }
        if ($foundParent instanceof \PhpParser\Node\Stmt\If_) {
            return;
        }
        if ($foundParent instanceof \PhpParser\Node\Stmt\Else_) {
            return;
        }
        // there is a return before this assign, to do not remove it and keep ti
        if (!$this->returnAnalyzer->isBeforeLastReturn($assign, $this->lastReturn)) {
            return;
        }
        $this->alwaysTemplateParameterAssigns[] = new \Rector\Nette\ValueObject\AlwaysTemplateParameterAssign($assign, $parameterName, $assign->expr);
    }
}
