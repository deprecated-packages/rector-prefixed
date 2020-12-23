<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php52\Rector\Switch_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Break_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Continue_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Switch_;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ConstantType;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://stackoverflow.com/a/12349889/1348344
 * @see \Rector\Php52\Tests\Rector\Switch_\ContinueToBreakInSwitchRector\ContinueToBreakInSwitchRectorTest
 */
final class ContinueToBreakInSwitchRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use break instead of continue in switch statements', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
function some_run($value)
{
    switch ($value) {
        case 1:
            echo 'Hi';
            continue;
        case 2:
            echo 'Hello';
            break;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
function some_run($value)
{
    switch ($value) {
        case 1:
            echo 'Hi';
            break;
        case 2:
            echo 'Hello';
            break;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Switch_::class];
    }
    /**
     * @param Switch_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        foreach ($node->cases as $case) {
            foreach ($case->stmts as $key => $caseStmt) {
                if (!$caseStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Continue_) {
                    continue;
                }
                $case->stmts[$key] = $this->processContinueStatement($caseStmt);
            }
        }
        return $node;
    }
    private function processContinueStatement(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Continue_ $continue) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt
    {
        if ($continue->num === null) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Break_();
        }
        if ($continue->num instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber) {
            if ($this->getValue($continue->num) <= 1) {
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Break_();
            }
        } elseif ($continue->num instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            return $this->processVariableNum($continue, $continue->num);
        }
        return $continue;
    }
    private function processVariableNum(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Continue_ $continue, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $numVariable) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt
    {
        $staticType = $this->getStaticType($numVariable);
        if ($staticType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ConstantType && $staticType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType && $staticType->getValue() <= 1) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Break_();
        }
        return $continue;
    }
}
