<?php

declare (strict_types=1);
namespace Rector\DeadCode\Rector\Assign;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Include_;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\NullsafeMethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\If_;
use Rector\Core\NodeAnalyzer\CompactFuncCallAnalyzer;
use Rector\Core\Php\ReservedKeywordAnalyzer;
use Rector\Core\PhpParser\Comparing\ConditionSearcher;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector\RemoveUnusedVariableAssignRectorTest
 */
final class RemoveUnusedVariableAssignRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ReservedKeywordAnalyzer
     */
    private $reservedKeywordAnalyzer;
    /**
     * @var CompactFuncCallAnalyzer
     */
    private $compactFuncCallAnalyzer;
    /**
     * @var ConditionSearcher
     */
    private $conditionSearcher;
    public function __construct(\Rector\Core\Php\ReservedKeywordAnalyzer $reservedKeywordAnalyzer, \Rector\Core\NodeAnalyzer\CompactFuncCallAnalyzer $compactFuncCallAnalyzer)
    {
        $this->reservedKeywordAnalyzer = $reservedKeywordAnalyzer;
        $this->compactFuncCallAnalyzer = $compactFuncCallAnalyzer;
        $this->conditionSearcher = new \Rector\Core\PhpParser\Comparing\ConditionSearcher();
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unused assigns to variables', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $value = 5;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var Variable $variable */
        $variable = $node->var;
        if (\is_string($variable->name) && $this->reservedKeywordAnalyzer->isNativeVariable($variable->name)) {
            return null;
        }
        // variable is used
        if ($this->isUsed($node, $variable)) {
            $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            $ifNode = $parentNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
            // check if next node is if
            if (!$ifNode instanceof \PhpParser\Node\Stmt\If_) {
                return null;
            }
            $nodeFound = $this->conditionSearcher->searchIfAndElseForVariableRedeclaration($node, $ifNode);
            if ($nodeFound) {
                $this->removeNode($node);
                return $node;
            }
            return null;
        }
        $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if ($node->expr instanceof \PhpParser\Node\Expr\MethodCall || $node->expr instanceof \PhpParser\Node\Expr\StaticCall) {
            // keep the expr, can have side effect
            return $node->expr;
        }
        $this->removeNode($node);
        return $node;
    }
    private function shouldSkip(\PhpParser\Node\Expr\Assign $assign) : bool
    {
        $classMethod = $assign->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if (!$classMethod instanceof \PhpParser\Node\FunctionLike) {
            return \true;
        }
        $variable = $assign->var;
        return !$variable instanceof \PhpParser\Node\Expr\Variable;
    }
    private function isUsed(\PhpParser\Node\Expr\Assign $assign, \PhpParser\Node\Expr\Variable $variable) : bool
    {
        $isUsedPrev = (bool) $this->betterNodeFinder->findFirstPreviousOfNode($variable, function (\PhpParser\Node $node) use($variable) : bool {
            return $this->isVariableNamed($node, $variable);
        });
        if ($isUsedPrev) {
            return \true;
        }
        if ($this->isUsedNext($variable)) {
            return \true;
        }
        /** @var FuncCall|MethodCall|New_|NullsafeMethodCall|StaticCall $expr */
        $expr = $assign->expr;
        if (!$this->isCall($expr)) {
            return \false;
        }
        return $this->isUsedInAssignExpr($expr, $assign);
    }
    private function isUsedNext(\PhpParser\Node\Expr\Variable $variable) : bool
    {
        return (bool) $this->betterNodeFinder->findFirstNext($variable, function (\PhpParser\Node $node) use($variable) : bool {
            if ($this->isVariableNamed($node, $variable)) {
                return \true;
            }
            if ($node instanceof \PhpParser\Node\Expr\FuncCall) {
                return $this->compactFuncCallAnalyzer->isInCompact($node, $variable);
            }
            return $node instanceof \PhpParser\Node\Expr\Include_;
        });
    }
    /**
     * @param FuncCall|MethodCall|New_|NullsafeMethodCall|StaticCall $expr
     */
    private function isUsedInAssignExpr(\PhpParser\Node\Expr $expr, \PhpParser\Node\Expr\Assign $assign) : bool
    {
        $args = $expr->args;
        foreach ($args as $arg) {
            $variable = $arg->value;
            if (!$variable instanceof \PhpParser\Node\Expr\Variable) {
                continue;
            }
            $previousAssign = $this->betterNodeFinder->findFirstPreviousOfNode($assign, function (\PhpParser\Node $node) use($variable) : bool {
                return $node instanceof \PhpParser\Node\Expr\Assign && $this->isVariableNamed($node->var, $variable);
            });
            if ($previousAssign instanceof \PhpParser\Node\Expr\Assign) {
                return $this->isUsed($assign, $variable);
            }
        }
        return \false;
    }
    private function isCall(\PhpParser\Node\Expr $expr) : bool
    {
        return $expr instanceof \PhpParser\Node\Expr\FuncCall || $expr instanceof \PhpParser\Node\Expr\MethodCall || $expr instanceof \PhpParser\Node\Expr\New_ || $expr instanceof \PhpParser\Node\Expr\NullsafeMethodCall || $expr instanceof \PhpParser\Node\Expr\StaticCall;
    }
    private function isVariableNamed(\PhpParser\Node $node, \PhpParser\Node\Expr\Variable $variable) : bool
    {
        if ($node instanceof \PhpParser\Node\Expr\MethodCall && $node->name instanceof \PhpParser\Node\Expr\Variable && \is_string($node->name->name)) {
            return $this->isName($variable, $node->name->name);
        }
        if ($node instanceof \PhpParser\Node\Expr\PropertyFetch && $node->name instanceof \PhpParser\Node\Expr\Variable && \is_string($node->name->name)) {
            return $this->isName($variable, $node->name->name);
        }
        if (!$node instanceof \PhpParser\Node\Expr\Variable) {
            return \false;
        }
        return $this->isName($variable, (string) $this->getName($node));
    }
}
