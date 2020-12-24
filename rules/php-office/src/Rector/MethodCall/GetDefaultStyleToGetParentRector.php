<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPOffice\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md#dedicated-class-to-manipulate-coordinates
 *
 * @see \Rector\PHPOffice\Tests\Rector\MethodCall\GetDefaultStyleToGetParentRector\GetDefaultStyleToGetParentRectorTest
 */
final class GetDefaultStyleToGetParentRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Methods to (new Worksheet())->getDefaultStyle() to getParent()->getDefaultStyle()', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $worksheet = new \PHPExcel_Worksheet();
        $worksheet->getDefaultStyle();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $worksheet = new \PHPExcel_Worksheet();
        $worksheet->getParent()->getDefaultStyle();
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
        if (!$this->isObjectType($node->var, 'PHPExcel_Worksheet')) {
            return null;
        }
        if (!$this->isName($node->name, 'getDefaultStyle')) {
            return null;
        }
        $variable = clone $node->var;
        $getParentMethodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($variable, 'getParent');
        $node->var = $getParentMethodCall;
        return $node;
    }
}
