<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Neon\NeonPrinter;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\BadGoodCodeSamplePrinter;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class PHPStanRuleCodeSamplePrinter implements \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Neon\NeonPrinter $neonPrinter, \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper $markdownCodeWrapper, \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\BadGoodCodeSamplePrinter $badGoodCodeSamplePrinter)
    {
        $this->neonPrinter = $neonPrinter;
        $this->markdownCodeWrapper = $markdownCodeWrapper;
        $this->badGoodCodeSamplePrinter = $badGoodCodeSamplePrinter;
    }
    public function isMatch(string $class) : bool
    {
        /** @noRector */
        return \is_a($class, '_PhpScoper2a4e7ab1ecbc\\PHPStan\\Rules\\Rule', \true);
    }
    /**
     * @return string[]
     */
    public function print(\_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample, \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
    {
        if ($codeSample instanceof \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample) {
            return $this->printConfigurableCodeSample($codeSample, $ruleDefinition);
        }
        return $this->badGoodCodeSamplePrinter->print($codeSample);
    }
    /**
     * @return string[]
     */
    private function printConfigurableCodeSample(\_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample $configuredCodeSample, \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
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
