<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\ArrowFunction;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrowFunction;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\NullableType;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\PhpParser\Node\UnionType;
use _PhpScoperb75b35f52b74\Rector\Php72\Rector\FuncCall\AbstractConvertToAnonymousFunctionRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.php.net/manual/en/functions.arrow.php
 *
 * @see \Rector\DowngradePhp74\Tests\Rector\ArrowFunction\ArrowFunctionToAnonymousFunctionRector\ArrowFunctionToAnonymousFunctionRectorTest
 */
final class ArrowFunctionToAnonymousFunctionRector extends \_PhpScoperb75b35f52b74\Rector\Php72\Rector\FuncCall\AbstractConvertToAnonymousFunctionRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace arrow functions with anonymous functions', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $delimiter = ",";
        $callable = fn($matches) => $delimiter . strtolower($matches[1]);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $delimiter = ",";
        $callable = function ($matches) use ($delimiter) {
            return $delimiter . strtolower($matches[1]);
        };
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrowFunction::class];
    }
    /**
     * @param ArrowFunction $node
     */
    public function shouldSkip(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        return \false;
    }
    /**
     * @param ArrowFunction $node
     * @return Param[]
     */
    public function getParameters(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array
    {
        return $node->params;
    }
    /**
     * @param ArrowFunction $node
     * @return Identifier|Name|NullableType|UnionType|null
     */
    public function getReturnType(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $node->returnType;
    }
    /**
     * @param ArrowFunction $node
     * @return Return_[]
     */
    public function getBody(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array
    {
        return [new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_($node->expr)];
    }
}
