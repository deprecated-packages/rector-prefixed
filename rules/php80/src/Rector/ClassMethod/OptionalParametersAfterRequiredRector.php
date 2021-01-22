<?php

declare (strict_types=1);
namespace Rector\Php80\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\TypeWithClassName;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\Rector\Php80\NodeResolver\RequireOptionalParamResolver $requireOptionalParamResolver)
    {
        $this->requireOptionalParamResolver = $requireOptionalParamResolver;
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
        return [\PhpParser\Node\Stmt\ClassMethod::class, \PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param ClassMethod|New_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return $this->refactorClassMethod($node);
        }
        return $this->refactorNew($node);
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
        $constructorClassMethod = $this->findClassMethodConstructorByNew($new);
        if (!$constructorClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        // we need orignal node, as the order might have already hcanged
        $originalClassMethod = $constructorClassMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE);
        if (!$originalClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        $expectedOrderedParams = $this->requireOptionalParamResolver->resolve($originalClassMethod);
        if ($expectedOrderedParams === $originalClassMethod->getParams()) {
            return null;
        }
        $newArgs = $this->resolveNewArgsOrderedByRequiredParams($expectedOrderedParams, $new);
        if ($new->args === $newArgs) {
            return null;
        }
        $new->args = $newArgs;
        return $new;
    }
    private function findClassMethodConstructorByNew(\PhpParser\Node\Expr\New_ $new) : ?\PhpParser\Node\Stmt\ClassMethod
    {
        $className = $this->getObjectType($new->class);
        if (!$className instanceof \PHPStan\Type\TypeWithClassName) {
            return null;
        }
        $constructorClassMethod = $this->nodeRepository->findClassMethod($className->getClassName(), \Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if (!$constructorClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        if ($constructorClassMethod->getParams() === []) {
            return null;
        }
        return $constructorClassMethod;
    }
    /**
     * @param array<int, Param> $expectedOrderedParams
     * @return array<int, Arg>
     */
    private function resolveNewArgsOrderedByRequiredParams(array $expectedOrderedParams, \PhpParser\Node\Expr\New_ $new) : array
    {
        $oldToNewPositions = \array_keys($expectedOrderedParams);
        $newArgs = [];
        foreach (\array_keys($new->args) as $position) {
            $newPosition = $oldToNewPositions[$position] ?? null;
            if ($newPosition === null) {
                continue;
            }
            $newArgs[$position] = $new->args[$newPosition];
        }
        return $newArgs;
    }
}
