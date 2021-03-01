<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\Tests\DirectoryToMarkdownPrinter\Fixture\PHPStan\Configurable;

use PHPStan\Rules\Rule;
use Symplify\RuleDocGenerator\Contract\ConfigurableRuleInterface;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class SomePHPStanRule implements \PHPStan\Rules\Rule, \Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface, \Symplify\RuleDocGenerator\Contract\ConfigurableRuleInterface
{
    /**
     * @var int
     */
    private $someValue;
    public function __construct(int $someValue = 10)
    {
        $this->someValue = $someValue;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Some description', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
bad code
CODE_SAMPLE
, <<<'CODE_SAMPLE'
good code
CODE_SAMPLE
, ['someValue' => 10])]);
    }
    public function getNodeType() : string
    {
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
    }
}
