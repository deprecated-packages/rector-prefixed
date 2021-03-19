<?php

declare (strict_types=1);
namespace Rector\PHPOffice\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BinaryOp\Plus;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Stmt\For_;
use PHPStan\Type\ObjectType;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md#column-index-based-on-1
 *
 * @see \Rector\Tests\PHPOffice\Rector\MethodCall\IncreaseColumnIndexRector\IncreaseColumnIndexRectorTest
 */
final class IncreaseColumnIndexRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ObjectType[]
     */
    private $worksheetObjectTypes = [];
    public function __construct()
    {
        $this->worksheetObjectTypes = [new \PHPStan\Type\ObjectType('PHPExcel_Worksheet'), new \PHPStan\Type\ObjectType('PHPExcel_Worksheet_PageSetup')];
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Column index changed from 0 to 1 - run only ONCE! changes current value without memory', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->nodeTypeResolver->isObjectTypes($node->var, $this->worksheetObjectTypes)) {
            return null;
        }
        if (!$this->isName($node->name, '*ByColumnAndRow')) {
            return null;
        }
        // increase column value
        $firstArgumentValue = $node->args[0]->value;
        if ($firstArgumentValue instanceof \PhpParser\Node\Scalar\LNumber) {
            ++$firstArgumentValue->value;
        }
        if ($firstArgumentValue instanceof \PhpParser\Node\Expr\BinaryOp) {
            $this->refactorBinaryOp($firstArgumentValue);
        }
        if ($firstArgumentValue instanceof \PhpParser\Node\Expr\Variable) {
            // check if for() value, rather update that
            $lNumber = $this->findPreviousForWithVariable($firstArgumentValue);
            if (!$lNumber instanceof \PhpParser\Node\Scalar\LNumber) {
                $node->args[0]->value = new \PhpParser\Node\Expr\BinaryOp\Plus($firstArgumentValue, new \PhpParser\Node\Scalar\LNumber(1));
                return null;
            }
            ++$lNumber->value;
        }
        return $node;
    }
    private function refactorBinaryOp(\PhpParser\Node\Expr\BinaryOp $binaryOp) : void
    {
        if ($binaryOp->left instanceof \PhpParser\Node\Scalar\LNumber) {
            ++$binaryOp->left->value;
            return;
        }
        if ($binaryOp->right instanceof \PhpParser\Node\Scalar\LNumber) {
            ++$binaryOp->right->value;
            return;
        }
    }
    private function findPreviousForWithVariable(\PhpParser\Node\Expr\Variable $variable) : ?\PhpParser\Node\Scalar\LNumber
    {
        $for = $this->betterNodeFinder->findFirstPreviousOfTypes($variable, [\PhpParser\Node\Stmt\For_::class]);
        if (!$for instanceof \PhpParser\Node\Stmt\For_) {
            return null;
        }
        $variableName = $this->getName($variable);
        if ($variableName === null) {
            return null;
        }
        $assignVariable = $this->findVariableAssignName($for->init, $variableName);
        if (!$assignVariable instanceof \PhpParser\Node\Expr\Assign) {
            return null;
        }
        $assignedExpr = $assignVariable->expr;
        if ($assignedExpr instanceof \PhpParser\Node\Scalar\LNumber) {
            return $assignedExpr;
        }
        return null;
    }
    /**
     * @param Node[] $node
     */
    private function findVariableAssignName(array $node, string $variableName) : ?\PhpParser\Node
    {
        return $this->betterNodeFinder->findFirst($node, function (\PhpParser\Node $node) use($variableName) : bool {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return \false;
            }
            if (!$node->var instanceof \PhpParser\Node\Expr\Variable) {
                return \false;
            }
            return $this->nodeNameResolver->isName($node->var, $variableName);
        });
    }
}
