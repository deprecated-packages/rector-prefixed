<?php

declare (strict_types=1);
namespace Rector\Php80\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\TypeWithClassName;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Php80\NodeResolver\ArgumentSorter;
use Rector\Php80\NodeResolver\RequireOptionalParamResolver;
use Rector\Php80\Reflection\MethodReflectionClassMethodResolver;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @changelog https://php.watch/versions/8.0#deprecate-required-param-after-optional
 *
 * @see \Rector\Tests\Php80\Rector\ClassMethod\OptionalParametersAfterRequiredRector\OptionalParametersAfterRequiredRectorTest
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
    /**
     * @var MethodReflectionClassMethodResolver
     */
    private $methodReflectionClassMethodResolver;
    public function __construct(\Rector\Php80\NodeResolver\RequireOptionalParamResolver $requireOptionalParamResolver, \Rector\Php80\NodeResolver\ArgumentSorter $argumentSorter, \Rector\Php80\Reflection\MethodReflectionClassMethodResolver $methodReflectionClassMethodResolver)
    {
        $this->requireOptionalParamResolver = $requireOptionalParamResolver;
        $this->argumentSorter = $argumentSorter;
        $this->methodReflectionClassMethodResolver = $methodReflectionClassMethodResolver;
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
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class, \PhpParser\Node\Expr\New_::class, \PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param ClassMethod|New_|MethodCall $node
     * @return \PhpParser\Node|null
     */
    public function refactor(\PhpParser\Node $node)
    {
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return $this->refactorClassMethod($node);
        }
        if ($node instanceof \PhpParser\Node\Expr\New_) {
            return $this->refactorNew($node);
        }
        return $this->refactorMethodCall($node);
    }
    /**
     * @return \PhpParser\Node\Stmt\ClassMethod|null
     */
    private function refactorClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod)
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
    /**
     * @return \PhpParser\Node\Expr\New_|null
     */
    private function refactorNew(\PhpParser\Node\Expr\New_ $new)
    {
        if ($new->args === []) {
            return null;
        }
        $newClassType = $this->nodeTypeResolver->resolve($new->class);
        if (!$newClassType instanceof \PHPStan\Type\TypeWithClassName) {
            return null;
        }
        $classMethod = $this->methodReflectionClassMethodResolver->resolve($newClassType->getClassName(), \Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if (!$classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        $expectedOrderedParams = $this->requireOptionalParamResolver->resolve($classMethod);
        if ($expectedOrderedParams === $classMethod->getParams()) {
            return null;
        }
        if (\count($new->args) !== \count($classMethod->getParams())) {
            return null;
        }
        $newArgs = $this->argumentSorter->sortArgsByExpectedParamOrder($new->args, $expectedOrderedParams);
        if ($new->args === $newArgs) {
            return null;
        }
        $new->args = $newArgs;
        return $new;
    }
    /**
     * @return \PhpParser\Node\Expr\MethodCall|null
     */
    private function refactorMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall)
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
