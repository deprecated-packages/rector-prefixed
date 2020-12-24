<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\Function_;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Function_\CamelCaseFunctionNamingToUnderscoreRector\CamelCaseFunctionNamingToUnderscoreRectorTest
 */
final class CamelCaseFunctionNamingToUnderscoreRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change CamelCase naming of functions to under_score naming', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param Function_|FuncCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $shortName = $this->resolveShortName($node);
        if ($shortName === null) {
            return null;
        }
        $underscoredName = \_PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings::camelCaseToUnderscore($shortName);
        if ($underscoredName === $shortName) {
            return null;
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($underscoredName);
        } elseif ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_) {
            $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($underscoredName);
        }
        return $node;
    }
    /**
     * @param Function_|FuncCall $node
     */
    private function resolveShortName(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        $functionOrFuncCallName = $this->getName($node);
        if ($functionOrFuncCallName === null) {
            return null;
        }
        $shortName = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::after($functionOrFuncCallName, '\\', -1);
        if ($shortName === null) {
            return $functionOrFuncCallName;
        }
        return $shortName;
    }
}
