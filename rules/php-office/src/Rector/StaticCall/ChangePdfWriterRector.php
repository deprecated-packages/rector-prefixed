<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPOffice\Rector\StaticCall;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md#writing-pdf
 *
 * @see \Rector\PHPOffice\Tests\Rector\StaticCall\ChangePdfWriterRector\ChangePdfWriterRectorTest
 */
final class ChangePdfWriterRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change init of PDF writer', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($this->isStaticCallNamed($node, 'PHPExcel_Settings', 'setPdfRendererName')) {
            $this->removeNode($node);
            return null;
        }
        if ($this->isStaticCallNamed($node, 'PHPExcel_Settings', 'setPdfRenderer')) {
            $this->removeNode($node);
            return null;
        }
        if ($this->isStaticCallNamed($node, 'PHPExcel_IOFactory', 'createWriter')) {
            if (!isset($node->args[1])) {
                return null;
            }
            $secondArgValue = $this->getValue($node->args[1]->value);
            if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($secondArgValue, '#pdf#i')) {
                return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified('_PhpScoper0a6b37af0871\\PhpOffice\\PhpSpreadsheet\\Writer\\Pdf\\Mpdf'), [$node->args[0]]);
            }
        }
        return $node;
    }
}
