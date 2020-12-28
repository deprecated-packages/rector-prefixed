<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Rector\Array_;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\ClosureUse;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.php.net/manual/en/language.types.callable.php#117260
 * @see https://3v4l.org/MsMbQ
 * @see https://3v4l.org/KM1Ji
 *
 * @see \Rector\CodeQuality\Tests\Rector\Array_\CallableThisArrayToAnonymousFunctionRector\CallableThisArrayToAnonymousFunctionRectorTest
 */
final class CallableThisArrayToAnonymousFunctionRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Convert [$this, "method"] to proper anonymous function', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $values = [1, 5, 3];
        usort($values, [$this, 'compareSize']);

        return $values;
    }

    private function compareSize($first, $second)
    {
        return $first <=> $second;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $values = [1, 5, 3];
        usort($values, function ($first, $second) {
            return $this->compareSize($first, $second);
        });

        return $values;
    }

    private function compareSize($first, $second)
    {
        return $first <=> $second;
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
        return [\PhpParser\Node\Expr\Array_::class];
    }
    /**
     * @param Array_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->shouldSkipArray($node)) {
            return null;
        }
        $firstArrayItem = $node->items[0];
        if (!$firstArrayItem instanceof \PhpParser\Node\Expr\ArrayItem) {
            return null;
        }
        $objectVariable = $firstArrayItem->value;
        if (!$objectVariable instanceof \PhpParser\Node\Expr\Variable && !$objectVariable instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return null;
        }
        $secondArrayItem = $node->items[1];
        if (!$secondArrayItem instanceof \PhpParser\Node\Expr\ArrayItem) {
            return null;
        }
        $methodName = $secondArrayItem->value;
        if (!$methodName instanceof \PhpParser\Node\Scalar\String_) {
            return null;
        }
        $classMethod = $this->matchCallableMethod($objectVariable, $methodName);
        if ($classMethod === null) {
            return null;
        }
        return $this->createAnonymousFunction($classMethod, $objectVariable);
    }
    private function shouldSkipArray(\PhpParser\Node\Expr\Array_ $array) : bool
    {
        // callback is exactly "[$two, 'items']"
        if (\count($array->items) !== 2) {
            return \true;
        }
        // can be totally empty in case of "[, $value]"
        if ($array->items[0] === null) {
            return \true;
        }
        if ($array->items[1] === null) {
            return \true;
        }
        return $this->isCallbackAtFunctionName($array, 'register_shutdown_function');
    }
    /**
     * @param Variable|PropertyFetch $objectExpr
     */
    private function matchCallableMethod(\PhpParser\Node\Expr $objectExpr, \PhpParser\Node\Scalar\String_ $string) : ?\PhpParser\Node\Stmt\ClassMethod
    {
        $methodName = $this->getValue($string);
        if (!\is_string($methodName)) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $objectType = $this->getObjectType($objectExpr);
        $objectType = $this->popFirstObjectType($objectType);
        if ($objectType instanceof \PHPStan\Type\ObjectType) {
            $class = $this->nodeRepository->findClass($objectType->getClassName());
            if ($class === null) {
                return null;
            }
            $classMethod = $class->getMethod($methodName);
            if ($classMethod === null) {
                return null;
            }
            if ($this->isName($objectExpr, 'this')) {
                return $classMethod;
            }
            // is public method of another service
            if ($classMethod->isPublic()) {
                return $classMethod;
            }
        }
        return null;
    }
    /**
     * @param Variable|PropertyFetch $node
     */
    private function createAnonymousFunction(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node $node) : \PhpParser\Node\Expr\Closure
    {
        $classMethodReturns = $this->betterNodeFinder->findInstanceOf((array) $classMethod->stmts, \PhpParser\Node\Stmt\Return_::class);
        $anonymousFunction = new \PhpParser\Node\Expr\Closure();
        $newParams = $this->copyParams($classMethod->params);
        $anonymousFunction->params = $newParams;
        $innerMethodCall = new \PhpParser\Node\Expr\MethodCall($node, $classMethod->name);
        $innerMethodCall->args = $this->convertParamsToArgs($newParams);
        if ($classMethod->returnType !== null) {
            $newReturnType = $classMethod->returnType;
            $newReturnType->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
            $anonymousFunction->returnType = $newReturnType;
        }
        // does method return something?
        if ($this->hasClassMethodReturn($classMethodReturns)) {
            $anonymousFunction->stmts[] = new \PhpParser\Node\Stmt\Return_($innerMethodCall);
        } else {
            $anonymousFunction->stmts[] = new \PhpParser\Node\Stmt\Expression($innerMethodCall);
        }
        if ($node instanceof \PhpParser\Node\Expr\Variable && !$this->isName($node, 'this')) {
            $anonymousFunction->uses[] = new \PhpParser\Node\Expr\ClosureUse($node);
        }
        return $anonymousFunction;
    }
    private function isCallbackAtFunctionName(\PhpParser\Node\Expr\Array_ $array, string $functionName) : bool
    {
        $parentNode = $array->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \PhpParser\Node\Arg) {
            return \false;
        }
        $parentParentNode = $parentNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentParentNode instanceof \PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->isName($parentParentNode, $functionName);
    }
    private function popFirstObjectType(\PHPStan\Type\Type $type) : \PHPStan\Type\Type
    {
        if ($type instanceof \PHPStan\Type\UnionType) {
            foreach ($type->getTypes() as $unionedType) {
                if (!$unionedType instanceof \PHPStan\Type\ObjectType) {
                    continue;
                }
                return $unionedType;
            }
        }
        return $type;
    }
    /**
     * @param Param[] $params
     * @return Param[]
     */
    private function copyParams(array $params) : array
    {
        $newParams = [];
        foreach ($params as $param) {
            $newParam = clone $param;
            $newParam->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
            $newParam->var->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
            $newParams[] = $newParam;
        }
        return $newParams;
    }
    /**
     * @param Param[] $params
     * @return Arg[]
     */
    private function convertParamsToArgs(array $params) : array
    {
        $args = [];
        foreach ($params as $param) {
            $args[] = new \PhpParser\Node\Arg($param->var);
        }
        return $args;
    }
    /**
     * @param Return_[] $nodes
     */
    private function hasClassMethodReturn(array $nodes) : bool
    {
        foreach ($nodes as $node) {
            if ($node->expr !== null) {
                return \true;
            }
        }
        return \false;
    }
}
