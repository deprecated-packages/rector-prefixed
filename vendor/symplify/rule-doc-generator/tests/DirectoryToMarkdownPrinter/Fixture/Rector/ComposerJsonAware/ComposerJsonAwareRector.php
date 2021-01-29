<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\Tests\DirectoryToMarkdownPrinter\Fixture\Rector\ComposerJsonAware;

use Rector\Core\Contract\Rector\RectorInterface;
use Rector\Core\RectorDefinition\RectorDefinition;
use Symplify\RuleDocGenerator\Contract\ConfigurableRuleInterface;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ComposerJsonAwareCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class ComposerJsonAwareRector implements \Rector\Core\Contract\Rector\RectorInterface, \Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface, \Symplify\RuleDocGenerator\Contract\ConfigurableRuleInterface
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Some change', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ComposerJsonAwareCodeSample(<<<'CODE_SAMPLE'
before
CODE_SAMPLE
, <<<'CODE_SAMPLE'
after
CODE_SAMPLE
, <<<'CODE_SAMPLE'
{
    "name": "some-project"
}
CODE_SAMPLE
)]);
    }
}
