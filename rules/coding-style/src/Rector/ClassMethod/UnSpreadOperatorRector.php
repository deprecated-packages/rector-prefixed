<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Rector\ClassMethod;

use RectorPrefix20210102\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ThisType;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionClass;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\ClassMethod\UnSpreadOperatorRector\UnSpreadOperatorRectorTest
 */
final class UnSpreadOperatorRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @see https://regex101.com/r/ChpDsj/1
     * @var string
     */
    private const ANONYMOUS_CLASS_REGEX = '#^AnonymousClass[\\w+]#';
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
     * @return string[]
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
    private function getClassFileNameByClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?string
    {
        $parent = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parent instanceof \PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $shortClassName = (string) $parent->name;
        if (\RectorPrefix20210102\Nette\Utils\Strings::match($shortClassName, self::ANONYMOUS_CLASS_REGEX)) {
            return null;
        }
        $reflectionClass = new \ReflectionClass((string) $parent->namespacedName);
        return (string) $reflectionClass->getFileName();
    }
    private function getClassFileNameByMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall) : ?string
    {
        $scope = $methodCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return null;
        }
        $type = $scope->getType($methodCall->var);
        if ($type instanceof \PHPStan\Type\ObjectType) {
            $classReflection = $type->getClassReflection();
            if ($classReflection === null) {
                return null;
            }
            return (string) $classReflection->getFileName();
        }
        if ($type instanceof \PHPStan\Type\ThisType) {
            $staticObjectType = $type->getStaticObjectType();
            $classReflection = $staticObjectType->getClassReflection();
            if ($classReflection === null) {
                return null;
            }
            return (string) $classReflection->getFileName();
        }
        return null;
    }
    private function processUnspreadOperatorClassMethodParams(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Stmt\ClassMethod
    {
        if ($this->isInVendor($classMethod)) {
            return null;
        }
        $params = $classMethod->params;
        if ($params === []) {
            return null;
        }
        $spreadVariables = $this->getSpreadVariables($params);
        if ($spreadVariables === []) {
            return null;
        }
        foreach (\array_keys($spreadVariables) as $key) {
            $classMethod->params[$key]->variadic = \false;
            $classMethod->params[$key]->type = new \PhpParser\Node\Identifier('array');
        }
        return $classMethod;
    }
    /**
     * @param ClassMethod|MethodCall $node
     */
    private function isInVendor(\PhpParser\Node $node) : bool
    {
        $scope = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        $fileName = $node instanceof \PhpParser\Node\Stmt\ClassMethod ? $this->getClassFileNameByClassMethod($node) : $this->getClassFileNameByMethodCall($node);
        if ($fileName === null) {
            return \false;
        }
        return \RectorPrefix20210102\Nette\Utils\Strings::contains($fileName, 'vendor');
    }
    private function processUnspreadOperatorMethodCallArgs(\PhpParser\Node\Expr\MethodCall $methodCall) : ?\PhpParser\Node\Expr\MethodCall
    {
        if ($this->isInVendor($methodCall)) {
            return null;
        }
        $args = $methodCall->args;
        if ($args === []) {
            return null;
        }
        $spreadVariables = $this->getSpreadVariables($args);
        if ($spreadVariables === []) {
            return null;
        }
        foreach (\array_keys($spreadVariables) as $key) {
            $methodCall->args[$key]->unpack = \false;
        }
        return $methodCall;
    }
    /**
     * @param Param[]|Arg[] $array
     * @return Param[]|Arg[]
     */
    private function getSpreadVariables(array $array) : array
    {
        $spreadVariables = [];
        foreach ($array as $key => $paramOrArg) {
            if ($paramOrArg instanceof \PhpParser\Node\Param && (!$paramOrArg->variadic || $paramOrArg->type !== null)) {
                continue;
            }
            if ($paramOrArg instanceof \PhpParser\Node\Arg && (!$paramOrArg->unpack || !$paramOrArg->value instanceof \PhpParser\Node\Expr\Variable)) {
                continue;
            }
            $spreadVariables[$key] = $paramOrArg;
        }
        return $spreadVariables;
    }
}
