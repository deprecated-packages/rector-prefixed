<?php

declare (strict_types=1);
namespace Rector\Php80\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Php80\NodeResolver\ArgumentSorter;
use Rector\Php80\NodeResolver\RequireOptionalParamResolver;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://php.watch/versions/8.0#deprecate-required-param-after-optional
 *
 * @see \Rector\Php80\Tests\Rector\ClassMethod\OptionalParametersAfterRequiredRector\OptionalParametersAfterRequiredRectorTest
 */
final class OptionalParametersAfterRequiredRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var RequireOptionalParamResolver
     */
    private $requireOptionalParamResolver;
    /**
     * @var ArgumentSorter
     */
    private $argumentSorter;
    public function __construct(\Rector\Php80\NodeResolver\RequireOptionalParamResolver $requireOptionalParamResolver, \Rector\Php80\NodeResolver\ArgumentSorter $argumentSorter)
    {
        $this->requireOptionalParamResolver = $requireOptionalParamResolver;
        $this->argumentSorter = $argumentSorter;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move required parameters after optional ones', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeObject
{
    public function run($optional = 1, $required)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeObject
{
    public function run($required, $optional = 1)
    {
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
        return [\PhpParser\Node\Stmt\ClassMethod::class, \PhpParser\Node\Expr\New_::class, \PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param ClassMethod|New_|MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return $this->refactorClassMethod($node);
        }
        if ($node instanceof \PhpParser\Node\Expr\New_) {
            return $this->refactorNew($node);
        }
        return $this->refactorMethodCall($node);
    }
    private function refactorClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Stmt\ClassMethod
    {
        if ($classMethod->params === []) {
            return null;
        }
        $expectedOrderParams = $this->requireOptionalParamResolver->resolve($classMethod);
        if ($classMethod->params === $expectedOrderParams) {
            return null;
        }
        $classMethod->params = $expectedOrderParams;
        return $classMethod;
    }
    private function refactorNew(\PhpParser\Node\Expr\New_ $new) : ?\PhpParser\Node\Expr\New_
    {
        if ($new->args === []) {
            return null;
        }
        $constructorClassMethod = $this->nodeRepository->findClassMethodConstructorByNew($new);
        if (!$constructorClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        // we need orignal node, as the order might have already hcanged
        $originalClassMethod = $constructorClassMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE);
        if (!$originalClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        $expectedOrderedParams = $this->requireOptionalParamResolver->resolve($originalClassMethod);
        if ($expectedOrderedParams === $constructorClassMethod->getParams()) {
            return null;
        }
        if (\count($new->args) !== \count($constructorClassMethod->getParams())) {
            return null;
        }
        $newArgs = $this->argumentSorter->sortArgsByExpectedParamOrder($new->args, $expectedOrderedParams);
        if ($new->args === $newArgs) {
            return null;
        }
        $new->args = $newArgs;
        return $new;
    }
    private function refactorMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall) : ?\PhpParser\Node\Expr\MethodCall
    {
        $classMethod = $this->nodeRepository->findClassMethodByMethodCall($methodCall);
        if (!$classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        // because parameters can be already changed
        $originalClassMethod = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE);
        if (!$originalClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        $expectedOrderedParams = $this->requireOptionalParamResolver->resolve($originalClassMethod);
        if ($expectedOrderedParams === $classMethod->getParams()) {
            return null;
        }
        if (\count($methodCall->args) !== \count($classMethod->getParams())) {
            return null;
        }
        $newArgs = $this->argumentSorter->sortArgsByExpectedParamOrder($methodCall->args, $expectedOrderedParams);
        if ($methodCall->args === $newArgs) {
            return null;
        }
        $methodCall->args = $newArgs;
        return $methodCall;
    }
}
