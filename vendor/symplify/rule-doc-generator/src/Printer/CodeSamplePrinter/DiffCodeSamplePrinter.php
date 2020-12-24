<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter;

use _PhpScopere8e811afab72\Symplify\MarkdownDiff\Differ\MarkdownDiffer;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
final class DiffCodeSamplePrinter
{
    /**
     * @var MarkdownDiffer
     */
    private $markdownDiffer;
    public function __construct(\_PhpScopere8e811afab72\Symplify\MarkdownDiff\Differ\MarkdownDiffer $markdownDiffer)
    {
        $this->markdownDiffer = $markdownDiffer;
    }
    /**
     * @return string[]
     */
    public function print(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample) : array
    {
        $lines = [];
        $lines[] = $this->markdownDiffer->diff($codeSample->getBadCode(), $codeSample->getGoodCode());
        return $lines;
    }
}
