<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface;
use Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\BadGoodCodeSamplePrinter;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class PHPCodeSnifferRuleCodeSamplePrinter implements \Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface
{
    /**
     * @var BadGoodCodeSamplePrinter
     */
    private $badGoodCodeSamplePrinter;
    public function __construct(\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\BadGoodCodeSamplePrinter $badGoodCodeSamplePrinter)
    {
        $this->badGoodCodeSamplePrinter = $badGoodCodeSamplePrinter;
    }
    public function isMatch(string $class) : bool
    {
        /** @noRector */
        return \is_a($class, 'RectorPrefix20210106\\PHP_CodeSniffer\\Sniffs\\Sniff', \true);
    }
    /**
     * @return string[]
     */
    public function print(\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample, \Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
    {
        return $this->badGoodCodeSamplePrinter->print($codeSample);
    }
}
