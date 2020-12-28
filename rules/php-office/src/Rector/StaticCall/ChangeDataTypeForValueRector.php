<?php

declare (strict_types=1);
namespace Rector\PHPOffice\Rector\StaticCall;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name\FullyQualified;
use Rector\Core\Rector\AbstractRector;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md#datatypedatatypeforvalue
 *
 * @see \Rector\PHPOffice\Tests\Rector\StaticCall\ChangeDataTypeForValueRector\ChangeDataTypeForValueRectorTest
 */
final class ChangeDataTypeForValueRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change argument DataType::dataTypeForValue() to DefaultValueBinder', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): void
    {
        $type = \PHPExcel_Cell_DataType::dataTypeForValue('value');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): void
    {
        $type = \PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder::dataTypeForValue('value');
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
        return [\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isStaticCallNamed($node, 'PHPExcel_Cell_DataType', 'dataTypeForValue')) {
            return null;
        }
        $node->class = new \PhpParser\Node\Name\FullyQualified('PhpOffice\\PhpSpreadsheet\\Cell\\DefaultValueBinder');
        return $node;
    }
}
