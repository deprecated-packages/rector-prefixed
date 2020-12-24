<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Array_;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClosureUse;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.php.net/manual/en/language.types.callable.php#117260
 * @see https://3v4l.org/MsMbQ
 * @see https://3v4l.org/KM1Ji
 *
 * @see \Rector\CodeQuality\Tests\Rector\Array_\CallableThisArrayToAnonymousFunctionRector\CallableThisArrayToAnonymousFunctionRectorTest
 */
final class CallableThisArrayToAnonymousFunctionRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Convert [$this, "method"] to proper anonymous function', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_::class];
    }
    /**
     * @param Array_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if ($this->shouldSkipArray($node)) {
            return null;
        }
        $firstArrayItem = $node->items[0];
        if (!$firstArrayItem instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem) {
            return null;
        }
        $objectVariable = $firstArrayItem->value;
        if (!$objectVariable instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable && !$objectVariable instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch) {
            return null;
        }
        $secondArrayItem = $node->items[1];
        if (!$secondArrayItem instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem) {
            return null;
        }
        $methodName = $secondArrayItem->value;
        if (!$methodName instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_) {
            return null;
        }
        $classMethod = $this->matchCallableMethod($objectVariable, $methodName);
        if ($classMethod === null) {
            return null;
        }
        return $this->createAnonymousFunction($classMethod, $objectVariable);
    }
    private function shouldSkipArray(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_ $array) : bool
    {
        // callback is exactly "[$two, 'items']"
        if (\count((array) $array->items) !== 2) {
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
    private function matchCallableMethod(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $objectExpr, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_ $string) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod
    {
        $methodName = $this->getValue($string);
        if (!\is_string($methodName)) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
        }
        $objectType = $this->getObjectType($objectExpr);
        $objectType = $this->popFirstObjectType($objectType);
        if ($objectType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType) {
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
    private function createAnonymousFunction(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure
    {
        $classMethodReturns = $this->betterNodeFinder->findInstanceOf((array) $classMethod->stmts, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_::class);
        $anonymousFunction = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure();
        $newParams = $this->copyParams($classMethod->params);
        $anonymousFunction->params = $newParams;
        $innerMethodCall = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall($node, $classMethod->name);
        $innerMethodCall->args = $this->convertParamsToArgs($newParams);
        if ($classMethod->returnType !== null) {
            $newReturnType = $classMethod->returnType;
            $newReturnType->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
            $anonymousFunction->returnType = $newReturnType;
        }
        // does method return something?
        if ($this->hasClassMethodReturn($classMethodReturns)) {
            $anonymousFunction->stmts[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_($innerMethodCall);
        } else {
            $anonymousFunction->stmts[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression($innerMethodCall);
        }
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable && !$this->isName($node, 'this')) {
            $anonymousFunction->uses[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClosureUse($node);
        }
        return $anonymousFunction;
    }
    private function isCallbackAtFunctionName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_ $array, string $functionName) : bool
    {
        $parentNode = $array->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg) {
            return \false;
        }
        $parentParentNode = $parentNode->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentParentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->isName($parentParentNode, $functionName);
    }
    private function popFirstObjectType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType) {
            foreach ($type->getTypes() as $unionedType) {
                if (!$unionedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType) {
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
            $newParam->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
            $newParam->var->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
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
            $args[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($param->var);
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
