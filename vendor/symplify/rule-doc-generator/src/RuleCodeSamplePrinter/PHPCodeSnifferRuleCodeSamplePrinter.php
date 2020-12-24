<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\BadGoodCodeSamplePrinter;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class PHPCodeSnifferRuleCodeSamplePrinter implements \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface
{
    /**
     * @var BadGoodCodeSamplePrinter
     */
    private $badGoodCodeSamplePrinter;
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\BadGoodCodeSamplePrinter $badGoodCodeSamplePrinter)
    {
        $this->badGoodCodeSamplePrinter = $badGoodCodeSamplePrinter;
    }
    public function isMatch(string $class) : bool
    {
        /** @noRector */
        return \is_a($class, '_PhpScoperb75b35f52b74\\PHP_CodeSniffer\\Sniffs\\Sniff', \true);
    }
    /**
     * @return string[]
     */
    public function print(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample, \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
    {
        return $this->badGoodCodeSamplePrinter->print($codeSample);
    }
}
