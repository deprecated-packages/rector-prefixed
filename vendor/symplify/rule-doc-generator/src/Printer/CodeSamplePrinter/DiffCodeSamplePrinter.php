<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter;

use _PhpScoper0a6b37af0871\Symplify\MarkdownDiff\Differ\MarkdownDiffer;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
final class DiffCodeSamplePrinter
{
    /**
     * @var MarkdownDiffer
     */
    private $markdownDiffer;
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\MarkdownDiff\Differ\MarkdownDiffer $markdownDiffer)
    {
        $this->markdownDiffer = $markdownDiffer;
    }
    /**
     * @return string[]
     */
    public function print(\_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample) : array
    {
        $lines = [];
        $lines[] = $this->markdownDiffer->diff($codeSample->getBadCode(), $codeSample->getGoodCode());
        return $lines;
    }
}
