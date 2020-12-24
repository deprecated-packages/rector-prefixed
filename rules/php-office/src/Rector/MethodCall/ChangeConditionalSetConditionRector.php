<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPOffice\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md#conditionalsetcondition
 *
 * @see \Rector\PHPOffice\Tests\Rector\MethodCall\ChangeConditionalSetConditionRector\ChangeConditionalSetConditionRectorTest
 */
final class ChangeConditionalSetConditionRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change argument PHPExcel_Style_Conditional->setCondition() to setConditions()', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isOnClassMethodCall($node, 'PHPExcel_Style_Conditional', 'setCondition')) {
            return null;
        }
        $node->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier('setConditions');
        $this->castArgumentToArrayIfNotArrayType($node);
        return $node;
    }
    private function castArgumentToArrayIfNotArrayType(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : void
    {
        $firstArgumentValue = $methodCall->args[0]->value;
        $firstArgumentStaticType = $this->getStaticType($firstArgumentValue);
        if ($firstArgumentStaticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType) {
            return;
        }
        // cast to array if not an array
        $methodCall->args[0]->value = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Array_($firstArgumentValue);
    }
}
