<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\FuncCall;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.php.net/manual/en/function.call-user-func-array.php#117655
 *
 * @see \Rector\Tests\CodingStyle\Rector\FuncCall\CallUserFuncCallToVariadicRector\CallUserFuncCallToVariadicRectorTest
 */
final class CallUserFuncCallToVariadicRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace call_user_func_call with variadic', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        call_user_func_array('some_function', $items);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        some_function(...$items);
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isName($node, 'call_user_func_array')) {
            return null;
        }
        $functionName = $this->valueResolver->getValue($node->args[0]->value);
        if (!\is_string($functionName)) {
            return null;
        }
        $args = [];
        $args[] = new \PhpParser\Node\Arg($node->args[1]->value, \false, \true);
        return $this->nodeFactory->createFuncCall($functionName, $args);
    }
}
