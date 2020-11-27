<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\Tests\DirectoryToMarkdownPrinter\Fixture\PHPCSFixer\Standard;

use _PhpScoper88fe6e0ad041\PhpCsFixer\AbstractFixer;
use _PhpScoper88fe6e0ad041\PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use _PhpScoper88fe6e0ad041\PhpCsFixer\Tokenizer\Tokens;
use PHPStan\Rules\Rule;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class SomeFixer extends \_PhpScoper88fe6e0ad041\PhpCsFixer\AbstractFixer implements \Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface
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
    protected function applyFix(\SplFileInfo $file, \_PhpScoper88fe6e0ad041\PhpCsFixer\Tokenizer\Tokens $tokens)
    {
    }
    public function getDefinition()
    {
    }
    public function isCandidate(\_PhpScoper88fe6e0ad041\PhpCsFixer\Tokenizer\Tokens $tokens)
    {
    }
}
