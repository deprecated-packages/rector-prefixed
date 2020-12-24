<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Rector\Function_;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Util\StaticRectorStrings;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Function_\CamelCaseFunctionNamingToUnderscoreRector\CamelCaseFunctionNamingToUnderscoreRectorTest
 */
final class CamelCaseFunctionNamingToUnderscoreRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change CamelCase naming of functions to under_score naming', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
function someCamelCaseFunction()
{
}

someCamelCaseFunction();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
function some_camel_case_function()
{
}

some_camel_case_function();
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param Function_|FuncCall $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $shortName = $this->resolveShortName($node);
        if ($shortName === null) {
            return null;
        }
        $underscoredName = \_PhpScoper2a4e7ab1ecbc\Rector\Core\Util\StaticRectorStrings::camelCaseToUnderscore($shortName);
        if ($underscoredName === $shortName) {
            return null;
        }
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall) {
            $node->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name($underscoredName);
        } elseif ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_) {
            $node->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier($underscoredName);
        }
        return $node;
    }
    /**
     * @param Function_|FuncCall $node
     */
    private function resolveShortName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?string
    {
        $functionOrFuncCallName = $this->getName($node);
        if ($functionOrFuncCallName === null) {
            return null;
        }
        $shortName = \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::after($functionOrFuncCallName, '\\', -1);
        if ($shortName === null) {
            return $functionOrFuncCallName;
        }
        return $shortName;
    }
}
