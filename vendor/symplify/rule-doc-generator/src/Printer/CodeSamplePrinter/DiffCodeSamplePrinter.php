<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter;

use _PhpScoperb75b35f52b74\Symplify\MarkdownDiff\Differ\MarkdownDiffer;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
final class DiffCodeSamplePrinter
{
    /**
     * @var MarkdownDiffer
     */
    private $markdownDiffer;
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\MarkdownDiff\Differ\MarkdownDiffer $markdownDiffer)
    {
        $this->markdownDiffer = $markdownDiffer;
    }
    /**
     * @return string[]
     */
    public function print(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample) : array
    {
        $lines = [];
        $lines[] = $this->markdownDiffer->diff($codeSample->getBadCode(), $codeSample->getGoodCode());
        return $lines;
    }
}
