<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter;

use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper;
final class BadGoodCodeSamplePrinter
{
    /**
     * @var MarkdownCodeWrapper
     */
    private $markdownCodeWrapper;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper $markdownCodeWrapper)
    {
        $this->markdownCodeWrapper = $markdownCodeWrapper;
    }
    /**
     * @return string[]
     */
    public function print(\_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample) : array
    {
        $lines = [];
        $lines[] = $this->markdownCodeWrapper->printPhpCode($codeSample->getBadCode());
        $lines[] = ':x:';
        $lines[] = '<br>';
        $lines[] = $this->markdownCodeWrapper->printPhpCode($codeSample->getGoodCode());
        $lines[] = ':+1:';
        return $lines;
    }
}
