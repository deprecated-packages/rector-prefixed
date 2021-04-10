<?php

declare (strict_types=1);
namespace Rector\DeadCode\Rector\Assign;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\NullsafeMethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\Php\ReservedKeywordAnalyzer;
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
    public function __construct(\Rector\Core\Php\ReservedKeywordAnalyzer $reservedKeywordAnalyzer)
    {
        $this->reservedKeywordAnalyzer = $reservedKeywordAnalyzer;
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
        $classMethod = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if (!$classMethod instanceof \PhpParser\Node\FunctionLike) {
            return null;
        }
        $variable = $node->var;
        if (!$variable instanceof \PhpParser\Node\Expr\Variable) {
            return null;
        }
        // variable is used
        if ($this->isUsed($node, $variable)) {
            return null;
        }
        $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if (\is_string($variable->name) && $this->reservedKeywordAnalyzer->isNativeVariable($variable->name)) {
            return null;
        }
        $this->removeNode($node);
        return $node;
    }
    private function isUsed(\PhpParser\Node\Expr\Assign $assign, \PhpParser\Node\Expr\Variable $variable) : bool
    {
        $isUsedPrev = (bool) $this->betterNodeFinder->findFirstPreviousOfNode($variable, function (\PhpParser\Node $node) use($variable) : bool {
            return $this->isVariableNamed($node, $variable);
        });
        if ($isUsedPrev) {
            return \true;
        }
        $isUsedNext = (bool) $this->betterNodeFinder->findFirstNext($variable, function (\PhpParser\Node $node) use($variable) : bool {
            return $this->isVariableNamed($node, $variable);
        });
        if ($isUsedNext) {
            return \true;
        }
        /** @var FuncCall|MethodCall|New_|NullsafeMethodCall|StaticCall $expr */
        $expr = $assign->expr;
        if (!$this->isCall($expr)) {
            return \false;
        }
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
