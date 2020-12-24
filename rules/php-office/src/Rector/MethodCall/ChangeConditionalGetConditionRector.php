<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PHPOffice\Rector\MethodCall;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\LNumber;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md#conditionalgetcondition
 *
 * @see \Rector\PHPOffice\Tests\Rector\MethodCall\ChangeConditionalGetConditionRector\ChangeConditionalGetConditionRectorTest
 */
final class ChangeConditionalGetConditionRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change argument PHPExcel_Style_Conditional->getCondition() to getConditions()', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): void
    {
        $conditional = new \PHPExcel_Style_Conditional;
        $someCondition = $conditional->getCondition();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): void
    {
        $conditional = new \PHPExcel_Style_Conditional;
        $someCondition = $conditional->getConditions()[0] ?? '';
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
        if (!$this->isOnClassMethodCall($node, 'PHPExcel_Style_Conditional', 'getCondition')) {
            return null;
        }
        $node->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier('getConditions');
        $arrayDimFetch = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch($node, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\LNumber(0));
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Coalesce($arrayDimFetch, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_(''));
    }
}
