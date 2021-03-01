<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\Tests\DirectoryToMarkdownPrinter\Fixture\Rector\ExtraFile;

use Rector\Core\Contract\Rector\RectorInterface;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class ExtraFileRector implements \Rector\Core\Contract\Rector\RectorInterface, \Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Some change', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample(<<<'CODE_SAMPLE'
before
CODE_SAMPLE
, <<<'CODE_SAMPLE'
after
CODE_SAMPLE
, <<<'CODE_SAMPLE'
extra file
CODE_SAMPLE
)]);
    }
}
