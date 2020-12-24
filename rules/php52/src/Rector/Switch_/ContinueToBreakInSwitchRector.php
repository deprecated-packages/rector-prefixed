<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php52\Rector\Switch_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Break_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Continue_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Switch_;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ConstantType;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://stackoverflow.com/a/12349889/1348344
 * @see \Rector\Php52\Tests\Rector\Switch_\ContinueToBreakInSwitchRector\ContinueToBreakInSwitchRectorTest
 */
final class ContinueToBreakInSwitchRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use break instead of continue in switch statements', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Switch_::class];
    }
    /**
     * @param Switch_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        foreach ($node->cases as $case) {
            foreach ($case->stmts as $key => $caseStmt) {
                if (!$caseStmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Continue_) {
                    continue;
                }
                $case->stmts[$key] = $this->processContinueStatement($caseStmt);
            }
        }
        return $node;
    }
    private function processContinueStatement(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Continue_ $continue) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt
    {
        if ($continue->num === null) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Break_();
        }
        if ($continue->num instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber) {
            if ($this->getValue($continue->num) <= 1) {
                return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Break_();
            }
        } elseif ($continue->num instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return $this->processVariableNum($continue, $continue->num);
        }
        return $continue;
    }
    private function processVariableNum(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Continue_ $continue, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $numVariable) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt
    {
        $staticType = $this->getStaticType($numVariable);
        if ($staticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantType && $staticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType && $staticType->getValue() <= 1) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Break_();
        }
        return $continue;
    }
}
