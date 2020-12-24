<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PHPOffice\Rector\MethodCall;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Plus;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\LNumber;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\For_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md#column-index-based-on-1
 *
 * @see \Rector\PHPOffice\Tests\Rector\MethodCall\IncreaseColumnIndexRector\IncreaseColumnIndexRectorTest
 */
final class IncreaseColumnIndexRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Column index changed from 0 to 1 - run only ONCE! changes current value without memory', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if (!$this->isObjectTypes($node->var, ['PHPExcel_Worksheet', 'PHPExcel_Worksheet_PageSetup'])) {
            return null;
        }
        if (!$this->isName($node->name, '*ByColumnAndRow')) {
            return null;
        }
        // increase column value
        $firstArgumentValue = $node->args[0]->value;
        if ($firstArgumentValue instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\LNumber) {
            ++$firstArgumentValue->value;
        }
        if ($firstArgumentValue instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp) {
            $this->refactorBinaryOp($firstArgumentValue);
        }
        if ($firstArgumentValue instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
            // check if for() value, rather update that
            $lNumber = $this->findPreviousForWithVariable($firstArgumentValue);
            if ($lNumber === null) {
                $node->args[0]->value = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Plus($firstArgumentValue, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\LNumber(1));
                return null;
            }
            ++$lNumber->value;
        }
        return $node;
    }
    private function refactorBinaryOp(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp $binaryOp) : void
    {
        if ($binaryOp->left instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\LNumber) {
            ++$binaryOp->left->value;
            return;
        }
        if ($binaryOp->right instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\LNumber) {
            ++$binaryOp->right->value;
            return;
        }
    }
    private function findPreviousForWithVariable(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\LNumber
    {
        /** @var For_|null $for */
        $for = $this->betterNodeFinder->findFirstPreviousOfTypes($variable, [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\For_::class]);
        if ($for === null) {
            return null;
        }
        $variableName = $this->getName($variable);
        if ($variableName === null) {
            return null;
        }
        $assignVariable = $this->findVariableAssignName($for->init, $variableName);
        if (!$assignVariable instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign) {
            return null;
        }
        if ($assignVariable->expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\LNumber) {
            return $assignVariable->expr;
        }
        return null;
    }
    /**
     * @param Node|Node[] $node
     */
    private function findVariableAssignName($node, string $variableName) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        return $this->betterNodeFinder->findFirst((array) $node, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($variableName) : bool {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign) {
                return \false;
            }
            return $this->isVariableName($node->var, $variableName);
        });
    }
}
