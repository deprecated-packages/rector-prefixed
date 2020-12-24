<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPOffice\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Plus;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\For_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md#column-index-based-on-1
 *
 * @see \Rector\PHPOffice\Tests\Rector\MethodCall\IncreaseColumnIndexRector\IncreaseColumnIndexRectorTest
 */
final class IncreaseColumnIndexRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Column index changed from 0 to 1 - run only ONCE! changes current value without memory', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): void
    {
        $worksheet = new \PHPExcel_Worksheet();
        $worksheet->setCellValueByColumnAndRow(0, 3, '1150');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): void
    {
        $worksheet = new \PHPExcel_Worksheet();
        $worksheet->setCellValueByColumnAndRow(1, 3, '1150');
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isObjectTypes($node->var, ['PHPExcel_Worksheet', 'PHPExcel_Worksheet_PageSetup'])) {
            return null;
        }
        if (!$this->isName($node->name, '*ByColumnAndRow')) {
            return null;
        }
        // increase column value
        $firstArgumentValue = $node->args[0]->value;
        if ($firstArgumentValue instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber) {
            ++$firstArgumentValue->value;
        }
        if ($firstArgumentValue instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp) {
            $this->refactorBinaryOp($firstArgumentValue);
        }
        if ($firstArgumentValue instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            // check if for() value, rather update that
            $lNumber = $this->findPreviousForWithVariable($firstArgumentValue);
            if ($lNumber === null) {
                $node->args[0]->value = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Plus($firstArgumentValue, new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber(1));
                return null;
            }
            ++$lNumber->value;
        }
        return $node;
    }
    private function refactorBinaryOp(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp $binaryOp) : void
    {
        if ($binaryOp->left instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber) {
            ++$binaryOp->left->value;
            return;
        }
        if ($binaryOp->right instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber) {
            ++$binaryOp->right->value;
            return;
        }
    }
    private function findPreviousForWithVariable(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber
    {
        /** @var For_|null $for */
        $for = $this->betterNodeFinder->findFirstPreviousOfTypes($variable, [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\For_::class]);
        if ($for === null) {
            return null;
        }
        $variableName = $this->getName($variable);
        if ($variableName === null) {
            return null;
        }
        $assignVariable = $this->findVariableAssignName($for->init, $variableName);
        if (!$assignVariable instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return null;
        }
        if ($assignVariable->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber) {
            return $assignVariable->expr;
        }
        return null;
    }
    /**
     * @param Node|Node[] $node
     */
    private function findVariableAssignName($node, string $variableName) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->betterNodeFinder->findFirst((array) $node, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($variableName) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return \false;
            }
            return $this->isVariableName($node->var, $variableName);
        });
    }
}
