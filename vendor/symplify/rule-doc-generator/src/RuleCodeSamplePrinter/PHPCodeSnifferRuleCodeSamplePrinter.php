<?php

declare (strict_types=1);
namespace RectorPrefix20201228\Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface;
use RectorPrefix20201228\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\BadGoodCodeSamplePrinter;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class PHPCodeSnifferRuleCodeSamplePrinter implements \RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface
{
    /**
     * @var BadGoodCodeSamplePrinter
     */
    private $badGoodCodeSamplePrinter;
    public function __construct(\RectorPrefix20201228\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\BadGoodCodeSamplePrinter $badGoodCodeSamplePrinter)
    {
        $this->badGoodCodeSamplePrinter = $badGoodCodeSamplePrinter;
    }
    public function isMatch(string $class) : bool
    {
        /** @noRector */
        return \is_a($class, 'RectorPrefix20201228\\PHP_CodeSniffer\\Sniffs\\Sniff', \true);
    }
    /**
     * @return string[]
     */
    public function print(\RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample, \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
    {
        return $this->badGoodCodeSamplePrinter->print($codeSample);
    }
}
