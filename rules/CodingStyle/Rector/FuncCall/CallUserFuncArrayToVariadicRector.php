<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Scalar\String_;
use Rector\CodingStyle\NodeFactory\ArrayCallableToMethodCallFactory;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @changelog https://www.php.net/manual/en/function.call-user-func-array.php#117655
 * @changelog https://3v4l.org/CBWt9
 *
 * @see \Rector\Tests\CodingStyle\Rector\FuncCall\CallUserFuncArrayToVariadicRector\CallUserFuncArrayToVariadicRectorTest
 */
final class CallUserFuncArrayToVariadicRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var \Rector\CodingStyle\NodeFactory\ArrayCallableToMethodCallFactory
     */
    private $arrayCallableToMethodCallFactory;
    public function __construct(\Rector\CodingStyle\NodeFactory\ArrayCallableToMethodCallFactory $arrayCallableToMethodCallFactory)
    {
        $this->arrayCallableToMethodCallFactory = $arrayCallableToMethodCallFactory;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace call_user_func_array() with variadic', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        if (!$this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::ARRAY_SPREAD)) {
            return null;
        }
        if (!$this->isName($node, 'call_user_func_array')) {
            return null;
        }
        $firstArgValue = $node->args[0]->value;
        $secondArgValue = $node->args[1]->value;
        if ($firstArgValue instanceof \PhpParser\Node\Scalar\String_) {
            $functionName = $this->valueResolver->getValue($firstArgValue);
            return $this->createFuncCall($secondArgValue, $functionName);
        }
        // method call
        if ($firstArgValue instanceof \PhpParser\Node\Expr\Array_) {
            return $this->createMethodCall($firstArgValue, $secondArgValue);
        }
        return null;
    }
    private function createFuncCall(\PhpParser\Node\Expr $expr, string $functionName) : \PhpParser\Node\Expr\FuncCall
    {
        $args = [];
        $args[] = $this->createUnpackedArg($expr);
        return $this->nodeFactory->createFuncCall($functionName, $args);
    }
    private function createMethodCall(\PhpParser\Node\Expr\Array_ $array, \PhpParser\Node\Expr $secondExpr) : ?\PhpParser\Node\Expr\MethodCall
    {
        $methodCall = $this->arrayCallableToMethodCallFactory->create($array);
        if (!$methodCall instanceof \PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        $methodCall->args[] = $this->createUnpackedArg($secondExpr);
        return $methodCall;
    }
    private function createUnpackedArg(\PhpParser\Node\Expr $expr) : \PhpParser\Node\Arg
    {
        return new \PhpParser\Node\Arg($expr, \false, \true);
    }
}
