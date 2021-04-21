<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Nop;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector\NewlineBeforeNewAssignSetRectorTest
 */
final class NewlineBeforeNewAssignSetRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string|null
     */
    private $previousStmtVariableName;
    /**
     * @var string|null
     */
    private $previousPreviousStmtVariableName;
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add extra space before new assign set', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        $value = new Value;
        $value->setValue(5);
        $value2 = new Value;
        $value2->setValue(1);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        $value = new Value;
        $value->setValue(5);

        $value2 = new Value;
        $value2->setValue(1);
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
        return [\PhpParser\Node\Stmt\ClassMethod::class, \PhpParser\Node\Stmt\Function_::class, \PhpParser\Node\Expr\Closure::class];
    }
    /**
     * @param ClassMethod|Function_|Closure $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $this->reset();
        $hasChanged = \false;
        foreach ((array) $node->stmts as $key => $stmt) {
            $currentStmtVariableName = $this->resolveCurrentStmtVariableName($stmt);
            if ($this->shouldAddEmptyLine($currentStmtVariableName, $node, $key)) {
                $hasChanged = \true;
                // insert newline before
                $stmts = (array) $node->stmts;
                \array_splice($stmts, $key, 0, [new \PhpParser\Node\Stmt\Nop()]);
                $node->stmts = $stmts;
            }
            $this->previousPreviousStmtVariableName = $this->previousStmtVariableName;
            $this->previousStmtVariableName = $currentStmtVariableName;
        }
        return $hasChanged ? $node : null;
    }
    private function reset() : void
    {
        $this->previousStmtVariableName = null;
        $this->previousPreviousStmtVariableName = null;
    }
    private function resolveCurrentStmtVariableName(\PhpParser\Node\Stmt $stmt) : ?string
    {
        $stmt = $this->unwrapExpression($stmt);
        if ($stmt instanceof \PhpParser\Node\Expr\Assign || $stmt instanceof \PhpParser\Node\Expr\MethodCall) {
            if ($this->shouldSkipLeftVariable($stmt)) {
                return null;
            }
            if (!$stmt->var instanceof \PhpParser\Node\Expr\MethodCall && !$stmt->var instanceof \PhpParser\Node\Expr\StaticCall) {
                return $this->getName($stmt->var);
            }
        }
        return null;
    }
    /**
     * @param ClassMethod|Function_|Closure $node
     */
    private function shouldAddEmptyLine(?string $currentStmtVariableName, \PhpParser\Node $node, int $key) : bool
    {
        if (!$this->isNewVariableThanBefore($currentStmtVariableName)) {
            return \false;
        }
        // this is already empty line before
        return !$this->isPreceededByEmptyLine($node, $key);
    }
    /**
     * @param Assign|MethodCall $node
     */
    private function shouldSkipLeftVariable(\PhpParser\Node $node) : bool
    {
        if (!$node->var instanceof \PhpParser\Node\Expr\Variable) {
            return \false;
        }
        // local method call
        return $this->nodeNameResolver->isName($node->var, 'this');
    }
    private function isNewVariableThanBefore(?string $currentStmtVariableName) : bool
    {
        if ($this->previousPreviousStmtVariableName === null) {
            return \false;
        }
        if ($this->previousStmtVariableName === null) {
            return \false;
        }
        if ($currentStmtVariableName === null) {
            return \false;
        }
        if ($this->previousStmtVariableName !== $this->previousPreviousStmtVariableName) {
            return \false;
        }
        return $this->previousStmtVariableName !== $currentStmtVariableName;
    }
    /**
     * @param ClassMethod|Function_|Closure $node
     */
    private function isPreceededByEmptyLine(\PhpParser\Node $node, int $key) : bool
    {
        if ($node->stmts === null) {
            return \false;
        }
        $previousNode = $node->stmts[$key - 1];
        $currentNode = $node->stmts[$key];
        return \abs($currentNode->getLine() - $previousNode->getLine()) >= 2;
    }
}
