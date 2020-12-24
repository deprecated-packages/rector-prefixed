<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter;

use _PhpScoper2a4e7ab1ecbc\Symplify\MarkdownDiff\Differ\MarkdownDiffer;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
final class DiffCodeSamplePrinter
{
    /**
     * @var MarkdownDiffer
     */
    private $markdownDiffer;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Symplify\MarkdownDiff\Differ\MarkdownDiffer $markdownDiffer)
    {
        $this->markdownDiffer = $markdownDiffer;
    }
    /**
     * @return string[]
     */
    public function print(\_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample) : array
    {
        $lines = [];
        $lines[] = $this->markdownDiffer->diff($codeSample->getBadCode(), $codeSample->getGoodCode());
        return $lines;
    }
}
