<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPOffice\Rector\StaticCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md#rendering-charts
 *
 * @see \Rector\PHPOffice\Tests\Rector\StaticCall\ChangeChartRendererRector\ChangeChartRendererRectorTest
 */
final class ChangeChartRendererRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change chart renderer', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): void
    {
        \PHPExcel_Settings::setChartRenderer($rendererName, $rendererLibraryPath);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): void
    {
        \PHPExcel_Settings::setChartRenderer(\PhpOffice\PhpSpreadsheet\Chart\Renderer\JpGraph::class);
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isStaticCallNamed($node, 'PHPExcel_Settings', 'setChartRenderer')) {
            return null;
        }
        if (\count((array) $node->args) === 1) {
            return null;
        }
        $arg = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($this->createClassConstantReference('_PhpScopere8e811afab72\\PhpOffice\\PhpSpreadsheet\\Chart\\Renderer\\JpGraph'));
        $node->args = [$arg];
        return $node;
    }
}
