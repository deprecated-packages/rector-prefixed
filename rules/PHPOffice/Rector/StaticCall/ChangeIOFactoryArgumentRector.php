<?php

declare (strict_types=1);
namespace Rector\PHPOffice\Rector\StaticCall;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Scalar\String_;
use PHPStan\Type\ObjectType;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @changelog https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md#renamed-readers-and-writers
 *
 * @see \Rector\Tests\PHPOffice\Rector\StaticCall\ChangeIOFactoryArgumentRector\ChangeIOFactoryArgumentRectorTest
 */
final class ChangeIOFactoryArgumentRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var array<string, string>
     */
    private const OLD_TO_NEW_TYPE = ['CSV' => 'Csv', 'Excel2003XML' => 'Xml', 'Excel2007' => 'Xlsx', 'Excel5' => 'Xls', 'Gnumeric' => 'Gnumeric', 'HTML' => 'Html', 'OOCalc' => 'Ods', 'OpenDocument' => 'Ods', 'PDF' => 'Pdf', 'SYLK' => 'Slk'];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change argument of PHPExcel_IOFactory::createReader(), PHPExcel_IOFactory::createWriter() and PHPExcel_IOFactory::identify()', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): void
    {
        $writer = \PHPExcel_IOFactory::createWriter('CSV');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): void
    {
        $writer = \PHPExcel_IOFactory::createWriter('Csv');
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
        return [\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $callerType = $this->getObjectType($node->class);
        if (!$callerType->isSuperTypeOf(new \PHPStan\Type\ObjectType('PHPExcel_IOFactory'))->yes()) {
            return null;
        }
        if (!$this->isNames($node->name, ['createReader', 'createWriter', 'identify'])) {
            return null;
        }
        $firstArgumentValue = $this->valueResolver->getValue($node->args[0]->value);
        $newValue = self::OLD_TO_NEW_TYPE[$firstArgumentValue] ?? null;
        if ($newValue === null) {
            return null;
        }
        $node->args[0]->value = new \PhpParser\Node\Scalar\String_($newValue);
        return $node;
    }
}
