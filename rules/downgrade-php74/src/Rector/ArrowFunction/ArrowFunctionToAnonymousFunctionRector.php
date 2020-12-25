<?php

declare (strict_types=1);
namespace Rector\DowngradePhp74\Rector\ArrowFunction;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\UnionType;
use Rector\Php72\Rector\FuncCall\AbstractConvertToAnonymousFunctionRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.php.net/manual/en/functions.arrow.php
 *
 * @see \Rector\DowngradePhp74\Tests\Rector\ArrowFunction\ArrowFunctionToAnonymousFunctionRector\ArrowFunctionToAnonymousFunctionRectorTest
 */
final class ArrowFunctionToAnonymousFunctionRector extends \Rector\Php72\Rector\FuncCall\AbstractConvertToAnonymousFunctionRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace arrow functions with anonymous functions', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Expr\ArrowFunction::class];
    }
    /**
     * @param ArrowFunction $node
     */
    public function shouldSkip(\PhpParser\Node $node) : bool
    {
        return \false;
    }
    /**
     * @param ArrowFunction $node
     * @return Param[]
     */
    public function getParameters(\PhpParser\Node $node) : array
    {
        return $node->params;
    }
    /**
     * @param ArrowFunction $node
     * @return Identifier|Name|NullableType|UnionType|null
     */
    public function getReturnType(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        return $node->returnType;
    }
    /**
     * @param ArrowFunction $node
     * @return Return_[]
     */
    public function getBody(\PhpParser\Node $node) : array
    {
        return [new \PhpParser\Node\Stmt\Return_($node->expr)];
    }
}
