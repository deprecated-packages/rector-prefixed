<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Neon\NeonPrinter;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\BadGoodCodeSamplePrinter;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class PHPStanRuleCodeSamplePrinter implements \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface
{
    /**
     * @var NeonPrinter
     */
    private $neonPrinter;
    /**
     * @var MarkdownCodeWrapper
     */
    private $markdownCodeWrapper;
    /**
     * @var BadGoodCodeSamplePrinter
     */
    private $badGoodCodeSamplePrinter;
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Neon\NeonPrinter $neonPrinter, \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper $markdownCodeWrapper, \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\BadGoodCodeSamplePrinter $badGoodCodeSamplePrinter)
    {
        $this->neonPrinter = $neonPrinter;
        $this->markdownCodeWrapper = $markdownCodeWrapper;
        $this->badGoodCodeSamplePrinter = $badGoodCodeSamplePrinter;
    }
    public function isMatch(string $class) : bool
    {
        /** @noRector */
        return \is_a($class, '_PhpScoperb75b35f52b74\\PHPStan\\Rules\\Rule', \true);
    }
    /**
     * @return string[]
     */
    public function print(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample, \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
    {
        if ($codeSample instanceof \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample) {
            return $this->printConfigurableCodeSample($codeSample, $ruleDefinition);
        }
        return $this->badGoodCodeSamplePrinter->print($codeSample);
    }
    /**
     * @return string[]
     */
    private function printConfigurableCodeSample(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample $configuredCodeSample, \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
    {
        $lines = [];
        $phpstanNeon = ['services' => [['class' => $ruleDefinition->getRuleClass(), 'tags' => ['phpstan.rules.rule'], 'arguments' => $configuredCodeSample->getConfiguration()]]];
        $printedNeon = $this->neonPrinter->printNeon($phpstanNeon);
        $lines[] = $this->markdownCodeWrapper->printYamlCode($printedNeon);
        $lines[] = '↓';
        $newLines = $this->badGoodCodeSamplePrinter->print($configuredCodeSample);
        return \array_merge($lines, $newLines);
    }
}
