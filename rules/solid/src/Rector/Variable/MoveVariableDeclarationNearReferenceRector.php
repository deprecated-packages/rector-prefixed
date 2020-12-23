<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\SOLID\Rector\Variable;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Do_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Else_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ElseIf_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\For_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Switch_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\TryCatch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\While_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeNestingScope\NodeFinder\ScopeAwareNodeFinder;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\SOLID\Tests\Rector\Variable\MoveVariableDeclarationNearReferenceRector\MoveVariableDeclarationNearReferenceRectorTest
 */
final class MoveVariableDeclarationNearReferenceRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ScopeAwareNodeFinder
     */
    private $scopeAwareNodeFinder;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeNestingScope\NodeFinder\ScopeAwareNodeFinder $scopeAwareNodeFinder)
    {
        $this->scopeAwareNodeFinder = $scopeAwareNodeFinder;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move variable declaration near its reference', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$var = 1;
if ($condition === null) {
    return $var;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
if ($condition === null) {
    $var = 1;
    return $var;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable::class];
    }
    /**
     * @param Variable $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $parent = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!($parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign && $parent->var === $node)) {
            return null;
        }
        $expression = $parent->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$expression instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        $parentExpression = $expression->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($this->isUsedAsArrayKey($parentExpression, $node)) {
            return null;
        }
        if ($this->isInsideCondition($expression)) {
            return null;
        }
        if ($this->hasPropertyInExpr($expression, $parent->expr)) {
            return null;
        }
        if ($this->hasReAssign($expression, $parent->var) || $this->hasReAssign($expression, $parent->expr)) {
            return null;
        }
        $variable = $this->getUsageInNextStmts($expression, $node);
        if (!$variable instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            return null;
        }
        /** @var Node $usageStmt */
        $usageStmt = $variable->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if ($this->isInsideLoopStmts($usageStmt)) {
            return null;
        }
        $this->addNodeBeforeNode($expression, $usageStmt);
        $this->removeNode($expression);
        return $node;
    }
    private function isUsedAsArrayKey(?\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $variable) : bool
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node) {
            return \false;
        }
        $arrayDimFetches = $this->betterNodeFinder->findInstanceOf($node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch::class);
        foreach ($arrayDimFetches as $arrayDimFetch) {
            /** @var Node|null $dim */
            $dim = $arrayDimFetch->dim;
            if (!$dim instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node) {
                continue;
            }
            $isFoundInKey = (bool) $this->betterNodeFinder->findFirst($dim, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use($variable) : bool {
                return $this->areNodesEqual($node, $variable);
            });
            if ($isFoundInKey) {
                return \true;
            }
        }
        return \false;
    }
    private function isInsideCondition(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression $expression) : bool
    {
        return (bool) $this->scopeAwareNodeFinder->findParentType($expression, [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Else_::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ElseIf_::class]);
    }
    private function hasPropertyInExpr(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression $expression, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst($expr, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool {
            return $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch;
        });
    }
    private function hasReAssign(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression $expression, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : bool
    {
        $next = $expression->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        $exprValues = $this->betterNodeFinder->find($expr, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool {
            return $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
        });
        if ($exprValues === []) {
            return \false;
        }
        while ($next) {
            foreach ($exprValues as $value) {
                $isReAssign = (bool) $this->betterNodeFinder->findFirst($next, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool {
                    $parent = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
                    $node = $this->mayBeArrayDimFetch($node);
                    if (!$parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
                        return \false;
                    }
                    return (string) $this->getName($node) === (string) $this->getName($parent->var);
                });
                if (!$isReAssign) {
                    continue;
                }
                return \true;
            }
            $next = $next->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        }
        return \false;
    }
    private function getUsageInNextStmts(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression $expression, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable
    {
        /** @var Node|null $next */
        $next = $expression->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if (!$next instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node) {
            return null;
        }
        if ($this->hasStaticCall($next)) {
            return null;
        }
        $countFound = $this->getCountFound($next, $variable);
        if ($countFound === 0 || $countFound >= 2) {
            return null;
        }
        $nextVariable = $this->getSameVarName([$next], $variable);
        if ($nextVariable instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            return $nextVariable;
        }
        return $this->getSameVarNameInNexts($next, $variable);
    }
    private function isInsideLoopStmts(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        $loopNode = $this->betterNodeFinder->findFirstParentInstanceOf($node, [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\For_::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\While_::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Do_::class]);
        return (bool) $loopNode;
    }
    private function mayBeArrayDimFetch(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : \_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $parent = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch) {
            $node = $parent->var;
        }
        return $node;
    }
    private function hasStaticCall(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst($node, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $n) : bool {
            return $n instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
        });
    }
    private function getCountFound(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $variable) : int
    {
        $countFound = 0;
        while ($node) {
            $isFound = (bool) $this->getSameVarName([$node], $variable);
            if ($isFound) {
                ++$countFound;
            }
            $countFound = $this->countWithElseIf($node, $variable, $countFound);
            $countFound = $this->countWithTryCatch($node, $variable, $countFound);
            $countFound = $this->countWithSwitchCase($node, $variable, $countFound);
            /** @var Node|null $node */
            $node = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        }
        return $countFound;
    }
    /**
     * @param array<int, Node|null> $multiNodes
     */
    private function getSameVarName(array $multiNodes, \_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable
    {
        foreach ($multiNodes as $multiNode) {
            if ($multiNode === null) {
                continue;
            }
            /** @var Variable|null $found */
            $found = $this->betterNodeFinder->findFirst($multiNode, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $n) use($node) : bool {
                $n = $this->mayBeArrayDimFetch($n);
                if (!$n instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
                    return \false;
                }
                return $this->isName($n, (string) $this->getName($node));
            });
            if ($found !== null) {
                return $found;
            }
        }
        return null;
    }
    private function getSameVarNameInNexts(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable
    {
        while ($node) {
            $found = $this->getSameVarName([$node], $variable);
            if ($found instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
                return $found;
            }
            /** @var Node|null $node */
            $node = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        }
        return null;
    }
    private function countWithElseIf(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $variable, int $countFound) : int
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_) {
            return $countFound;
        }
        $isFoundElseIf = (bool) $this->getSameVarName($node->elseifs, $variable);
        $isFoundElse = (bool) $this->getSameVarName([$node->else], $variable);
        if ($isFoundElseIf || $isFoundElse) {
            ++$countFound;
        }
        return $countFound;
    }
    private function countWithTryCatch(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $variable, int $countFound) : int
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\TryCatch) {
            return $countFound;
        }
        $isFoundInCatch = (bool) $this->getSameVarName($node->catches, $variable);
        $isFoundInFinally = (bool) $this->getSameVarName([$node->finally], $variable);
        if ($isFoundInCatch || $isFoundInFinally) {
            ++$countFound;
        }
        return $countFound;
    }
    private function countWithSwitchCase(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $variable, int $countFound) : int
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Switch_) {
            return $countFound;
        }
        $isFoundInCases = (bool) $this->getSameVarName($node->cases, $variable);
        if ($isFoundInCases) {
            ++$countFound;
        }
        return $countFound;
    }
}
