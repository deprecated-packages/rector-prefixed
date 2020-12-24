<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Rector\Function_;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Function_\CamelCaseFunctionNamingToUnderscoreRector\CamelCaseFunctionNamingToUnderscoreRectorTest
 */
final class CamelCaseFunctionNamingToUnderscoreRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change CamelCase naming of functions to under_score naming', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param Function_|FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $shortName = $this->resolveShortName($node);
        if ($shortName === null) {
            return null;
        }
        $underscoredName = \_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::camelCaseToUnderscore($shortName);
        if ($underscoredName === $shortName) {
            return null;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Name($underscoredName);
        } elseif ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_) {
            $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($underscoredName);
        }
        return $node;
    }
    /**
     * @param Function_|FuncCall $node
     */
    private function resolveShortName(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        $functionOrFuncCallName = $this->getName($node);
        if ($functionOrFuncCallName === null) {
            return null;
        }
        $shortName = \_PhpScopere8e811afab72\Nette\Utils\Strings::after($functionOrFuncCallName, '\\', -1);
        if ($shortName === null) {
            return $functionOrFuncCallName;
        }
        return $shortName;
    }
}
