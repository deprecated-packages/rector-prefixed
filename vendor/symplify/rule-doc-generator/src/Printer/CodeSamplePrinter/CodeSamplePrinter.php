<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter;

use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Symplify\RuleDocGenerator\Tests\DirectoryToMarkdownPrinter\DirectoryToMarkdownPrinterTest
 */
final class CodeSamplePrinter
{
    /**
     * @var RuleCodeSamplePrinterInterface[]
     */
    private $ruleCodeSamplePrinters = [];
    /**
     * @param RuleCodeSamplePrinterInterface[] $ruleCodeSamplePrinters
     */
    public function __construct(array $ruleCodeSamplePrinters)
    {
        $this->ruleCodeSamplePrinters = $ruleCodeSamplePrinters;
    }
    /**
     * @return string[]
     */
    public function print(\_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
    {
        $lines = [];
        foreach ($ruleDefinition->getCodeSamples() as $codeSample) {
            foreach ($this->ruleCodeSamplePrinters as $ruleCodeSamplePrinter) {
                if (!$ruleCodeSamplePrinter->isMatch($ruleDefinition->getRuleClass())) {
                    continue;
                }
                $newLines = $ruleCodeSamplePrinter->print($codeSample, $ruleDefinition);
                $lines = \array_merge($lines, $newLines);
                break;
            }
            $lines[] = '<br>';
        }
        return $lines;
    }
}
