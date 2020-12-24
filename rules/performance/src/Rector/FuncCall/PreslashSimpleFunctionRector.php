<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Performance\Rector\FuncCall;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://stackoverflow.com/questions/55419673/php7-adding-a-slash-to-all-standard-php-functions-php-cs-fixer-rule
 *
 * @see \Rector\Performance\Tests\Rector\FuncCall\PreslashSimpleFunctionRector\PreslashSimpleFunctionRectorTest
 */
final class PreslashSimpleFunctionRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add pre-slash to short named functions to improve performance', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function shorten($value)
    {
        return trim($value);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function shorten($value)
    {
        return \trim($value);
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified) {
            return null;
        }
        $functionName = $this->getName($node);
        if ($functionName === null) {
            return null;
        }
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($functionName, '\\')) {
            return null;
        }
        $node->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified($functionName);
        return $node;
    }
}
