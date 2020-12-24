<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\BadGoodCodeSamplePrinter;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class PHPCodeSnifferRuleCodeSamplePrinter implements \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface
{
    /**
     * @var BadGoodCodeSamplePrinter
     */
    private $badGoodCodeSamplePrinter;
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\BadGoodCodeSamplePrinter $badGoodCodeSamplePrinter)
    {
        $this->badGoodCodeSamplePrinter = $badGoodCodeSamplePrinter;
    }
    public function isMatch(string $class) : bool
    {
        /** @noRector */
        return \is_a($class, '_PhpScoper0a6b37af0871\\PHP_CodeSniffer\\Sniffs\\Sniff', \true);
    }
    /**
     * @return string[]
     */
    public function print(\_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample, \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
    {
        return $this->badGoodCodeSamplePrinter->print($codeSample);
    }
}
