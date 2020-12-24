<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PHPOffice\Rector\MethodCall;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Array_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md#conditionalsetcondition
 *
 * @see \Rector\PHPOffice\Tests\Rector\MethodCall\ChangeConditionalSetConditionRector\ChangeConditionalSetConditionRectorTest
 */
final class ChangeConditionalSetConditionRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change argument PHPExcel_Style_Conditional->setCondition() to setConditions()', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): void
    {
        $conditional = new \PHPExcel_Style_Conditional;
        $someCondition = $conditional->setCondition(1);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): void
    {
        $conditional = new \PHPExcel_Style_Conditional;
        $someCondition = $conditional->setConditions((array) 1);
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
        if (!$this->isOnClassMethodCall($node, 'PHPExcel_Style_Conditional', 'setCondition')) {
            return null;
        }
        $node->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier('setConditions');
        $this->castArgumentToArrayIfNotArrayType($node);
        return $node;
    }
    private function castArgumentToArrayIfNotArrayType(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall $methodCall) : void
    {
        $firstArgumentValue = $methodCall->args[0]->value;
        $firstArgumentStaticType = $this->getStaticType($firstArgumentValue);
        if ($firstArgumentStaticType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType) {
            return;
        }
        // cast to array if not an array
        $methodCall->args[0]->value = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Array_($firstArgumentValue);
    }
}
