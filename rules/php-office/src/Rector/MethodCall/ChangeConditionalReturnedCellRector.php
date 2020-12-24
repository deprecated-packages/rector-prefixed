<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPOffice\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\PHPOffice\ValueObject\ConditionalSetValue;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md#dropped-conditionally-returned-cell
 *
 * @see \Rector\PHPOffice\Tests\Rector\MethodCall\ChangeConditionalReturnedCellRector\ChangeConditionalReturnedCellRectorTest
 */
final class ChangeConditionalReturnedCellRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ConditionalSetValue[]
     */
    private $conditionalSetValues = [];
    public function __construct()
    {
        $this->conditionalSetValues[] = new \_PhpScopere8e811afab72\Rector\PHPOffice\ValueObject\ConditionalSetValue('setCellValue', 'getCell', 'setValue', 2, \false);
        $this->conditionalSetValues[] = new \_PhpScopere8e811afab72\Rector\PHPOffice\ValueObject\ConditionalSetValue('setCellValueByColumnAndRow', 'getCellByColumnAndRow', 'setValue', 3, \true);
        $this->conditionalSetValues[] = new \_PhpScopere8e811afab72\Rector\PHPOffice\ValueObject\ConditionalSetValue('setCellValueExplicit', 'getCell', 'setValueExplicit', 3, \false);
        $this->conditionalSetValues[] = new \_PhpScopere8e811afab72\Rector\PHPOffice\ValueObject\ConditionalSetValue('setCellValueExplicitByColumnAndRow', 'getCellByColumnAndRow', 'setValueExplicit', 4, \true);
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change conditional call to getCell()', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): void
    {
        $worksheet = new \PHPExcel_Worksheet();
        $cell = $worksheet->setCellValue('A1', 'value', true);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): void
    {
        $worksheet = new \PHPExcel_Worksheet();
        $cell = $worksheet->getCell('A1')->setValue('value');
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
        foreach ($this->conditionalSetValues as $conditionalSetValue) {
            if (!$this->isName($node->name, $conditionalSetValue->getOldMethod())) {
                continue;
            }
            if (!isset($node->args[$conditionalSetValue->getArgPosition()])) {
                continue;
            }
            $args = $node->args;
            unset($args[$conditionalSetValue->getArgPosition()]);
            $locationArgs = [];
            $locationArgs[] = $args[0];
            unset($args[0]);
            if ($conditionalSetValue->hasRow()) {
                $locationArgs[] = $args[1];
                unset($args[1]);
            }
            $variable = clone $node->var;
            $getCellMethodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($variable, $conditionalSetValue->getNewGetMethod(), $locationArgs);
            $node->var = $getCellMethodCall;
            $node->args = $args;
            $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($conditionalSetValue->getNewSetMethod());
        }
        return $node;
    }
}
