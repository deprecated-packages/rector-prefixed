<?php

declare (strict_types=1);
namespace Rector\PHPOffice\Rector\StaticCall;

use RectorPrefix20210408\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name\FullyQualified;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md#writing-pdf
 *
 * @see \Rector\Tests\PHPOffice\Rector\StaticCall\ChangePdfWriterRector\ChangePdfWriterRectorTest
 */
final class ChangePdfWriterRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change init of PDF writer', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): void
    {
        \PHPExcel_Settings::setPdfRendererName(PHPExcel_Settings::PDF_RENDERER_MPDF);
        \PHPExcel_Settings::setPdfRenderer($somePath);
        $writer = \PHPExcel_IOFactory::createWriter($spreadsheet, 'PDF');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): void
    {
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
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
        $callerType = $this->nodeTypeResolver->resolve($node->class);
        if ($this->isSettingsPdfRendererStaticCall($callerType, $node)) {
            $this->removeNode($node);
            return null;
        }
        if ($callerType->isSuperTypeOf(new \PHPStan\Type\ObjectType('PHPExcel_IOFactory'))->yes() && $this->nodeNameResolver->isName($node->name, 'createWriter')) {
            if (!isset($node->args[1])) {
                return null;
            }
            $secondArgValue = $this->valueResolver->getValue($node->args[1]->value);
            if (\RectorPrefix20210408\Nette\Utils\Strings::match($secondArgValue, '#pdf#i')) {
                return new \PhpParser\Node\Expr\New_(new \PhpParser\Node\Name\FullyQualified('PhpOffice\\PhpSpreadsheet\\Writer\\Pdf\\Mpdf'), [$node->args[0]]);
            }
        }
        return $node;
    }
    private function isSettingsPdfRendererStaticCall(\PHPStan\Type\Type $callerType, \PhpParser\Node\Expr\StaticCall $staticCall) : bool
    {
        if (!$callerType->isSuperTypeOf(new \PHPStan\Type\ObjectType('PHPExcel_Settings'))->yes()) {
            return \false;
        }
        return $this->nodeNameResolver->isNames($staticCall->name, ['setPdfRendererName', 'setPdfRenderer']);
    }
}
