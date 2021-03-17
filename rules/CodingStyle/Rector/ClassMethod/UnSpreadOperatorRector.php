<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\CodingStyle\NodeAnalyzer\SpreadVariablesCollector;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector\UnSpreadOperatorRectorTest
 */
final class UnSpreadOperatorRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var SpreadVariablesCollector
     */
    private $spreadVariablesCollector;
    public function __construct(\Rector\CodingStyle\NodeAnalyzer\SpreadVariablesCollector $spreadVariablesCollector)
    {
        $this->spreadVariablesCollector = $spreadVariablesCollector;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove spread operator', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run(...$array)
    {
    }

    public function execute(array $data)
    {
        $this->run(...$data);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run(array $array)
    {
    }

    public function execute(array $data)
    {
        $this->run($data);
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
        return [\PhpParser\Node\Stmt\ClassMethod::class, \PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param ClassMethod|MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return $this->processUnspreadOperatorClassMethodParams($node);
        }
        return $this->processUnspreadOperatorMethodCallArgs($node);
    }
    private function processUnspreadOperatorClassMethodParams(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Stmt\ClassMethod
    {
        $spreadParams = $this->spreadVariablesCollector->resolveFromClassMethod($classMethod);
        if ($spreadParams === []) {
            return null;
        }
        foreach ($spreadParams as $spreadParam) {
            $spreadParam->variadic = \false;
            $spreadParam->type = new \PhpParser\Node\Identifier('array');
        }
        return $classMethod;
    }
    private function processUnspreadOperatorMethodCallArgs(\PhpParser\Node\Expr\MethodCall $methodCall) : ?\PhpParser\Node\Expr\MethodCall
    {
        $classMethod = $this->nodeRepository->findClassMethodByMethodCall($methodCall);
        if (!$classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        $spreadParams = $this->spreadVariablesCollector->resolveFromClassMethod($classMethod);
        if ($spreadParams === []) {
            return null;
        }
        $firstSpreadParamPosition = \array_key_first($spreadParams);
        $variadicArgs = $this->resolveVariadicArgsByVariadicParams($methodCall, $firstSpreadParamPosition);
        $hasUnpacked = \false;
        foreach ($variadicArgs as $position => $variadicArg) {
            if ($variadicArg->unpack) {
                $variadicArg->unpack = \false;
                $hasUnpacked = \true;
                $methodCall->args[$position] = $variadicArg;
            }
        }
        if ($hasUnpacked) {
            return $methodCall;
        }
        $methodCall->args[$firstSpreadParamPosition] = new \PhpParser\Node\Arg($this->nodeFactory->createArray($variadicArgs));
        return $methodCall;
    }
    /**
     * @return Arg[]
     */
    private function resolveVariadicArgsByVariadicParams(\PhpParser\Node\Expr\MethodCall $methodCall, int $firstSpreadParamPosition) : array
    {
        $variadicArgs = [];
        foreach ($methodCall->args as $position => $arg) {
            if ($position < $firstSpreadParamPosition) {
                continue;
            }
            $variadicArgs[] = $arg;
            $this->nodeRemover->removeArg($methodCall, $position);
        }
        return $variadicArgs;
    }
}
