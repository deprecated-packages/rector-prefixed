<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\Tests\DirectoryToMarkdownPrinter\Fixture\PHPStan\Standard;

use PHPStan\Rules\Rule;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class SomePHPStanRule implements \PHPStan\Rules\Rule, \Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Some description', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
bad code
CODE_SAMPLE
, <<<'CODE_SAMPLE'
good code
CODE_SAMPLE
)]);
    }
    public function getNodeType() : string
    {
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
    }
}
