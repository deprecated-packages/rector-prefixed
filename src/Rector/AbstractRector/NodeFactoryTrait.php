<?php

declare (strict_types=1);
namespace Rector\Core\Rector\AbstractRector;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use Rector\Core\PhpParser\Node\NodeFactory;
/**
 * This could be part of @see AbstractRector, but decopuling to trait
 * makes clear what code has 1 purpose.
 */
trait NodeFactoryTrait
{
    /**
     * @var NodeFactory
     */
    protected $nodeFactory;
    /**
     * @required
     */
    public function autowireNodeFactoryTrait(\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory) : void
    {
        $this->nodeFactory = $nodeFactory;
    }
    /**
     * @param Expr[]|Arg[] $args
     */
    protected function createStaticCall(string $class, string $method, array $args = []) : \PhpParser\Node\Expr\StaticCall
    {
        $args = $this->wrapToArg($args);
        if (\in_array($class, ['self', 'parent', 'static'], \true)) {
            $class = new \PhpParser\Node\Name($class);
        } else {
            $class = new \PhpParser\Node\Name\FullyQualified($class);
        }
        return new \PhpParser\Node\Expr\StaticCall($class, $method, $args);
    }
    /**
     * @param Expr[] $exprsToConcat
     */
    protected function createConcat(array $exprsToConcat) : ?\PhpParser\Node\Expr\BinaryOp\Concat
    {
        return $this->nodeFactory->createConcat($exprsToConcat);
    }
    protected function createClassConstFetch(string $class, string $constant) : \PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->nodeFactory->createClassConstFetch($class, $constant);
    }
    protected function createNull() : \PhpParser\Node\Expr\ConstFetch
    {
        return new \PhpParser\Node\Expr\ConstFetch(new \PhpParser\Node\Name('null'));
    }
    protected function createFalse() : \PhpParser\Node\Expr\ConstFetch
    {
        return new \PhpParser\Node\Expr\ConstFetch(new \PhpParser\Node\Name('false'));
    }
    protected function createTrue() : \PhpParser\Node\Expr\ConstFetch
    {
        return new \PhpParser\Node\Expr\ConstFetch(new \PhpParser\Node\Name('true'));
    }
    /**
     * @param mixed $argument
     */
    protected function createArg($argument) : \PhpParser\Node\Arg
    {
        return $this->nodeFactory->createArg($argument);
    }
    /**
     * @param mixed[] $arguments
     * @return Arg[]
     */
    protected function createArgs(array $arguments) : array
    {
        return $this->nodeFactory->createArgs($arguments);
    }
    /**
     * @param Node[]|mixed[] $nodes
     */
    protected function createArray(array $nodes) : \PhpParser\Node\Expr\Array_
    {
        return $this->nodeFactory->createArray($nodes);
    }
    /**
     * @param mixed[] $arguments
     */
    protected function createFuncCall(string $name, array $arguments = []) : \PhpParser\Node\Expr\FuncCall
    {
        return $this->nodeFactory->createFuncCall($name, $arguments);
    }
    protected function createClassConstantReference(string $class) : \PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->nodeFactory->createClassConstReference($class);
    }
    protected function createPropertyAssignmentWithExpr(string $propertyName, \PhpParser\Node\Expr $expr) : \PhpParser\Node\Expr\Assign
    {
        return $this->nodeFactory->createPropertyAssignmentWithExpr($propertyName, $expr);
    }
    /**
     * @param string|Expr $variable
     * @param mixed[] $arguments
     */
    protected function createMethodCall($variable, string $method, array $arguments = []) : \PhpParser\Node\Expr\MethodCall
    {
        return $this->nodeFactory->createMethodCall($variable, $method, $arguments);
    }
    /**
     * @param mixed[] $arguments
     */
    protected function createLocalMethodCall(string $method, array $arguments = []) : \PhpParser\Node\Expr\MethodCall
    {
        $variable = new \PhpParser\Node\Expr\Variable('this');
        return $this->nodeFactory->createMethodCall($variable, $method, $arguments);
    }
    /**
     * @param string|Expr $variable
     */
    protected function createPropertyFetch($variable, string $property) : \PhpParser\Node\Expr\PropertyFetch
    {
        return $this->nodeFactory->createPropertyFetch($variable, $property);
    }
    /**
     * @param Expr[]|Arg[] $args
     * @return Arg[]
     */
    private function wrapToArg(array $args) : array
    {
        $sureArgs = [];
        foreach ($args as $arg) {
            if ($arg instanceof \PhpParser\Node\Arg) {
                $sureArgs[] = $arg;
                continue;
            }
            $sureArgs[] = new \PhpParser\Node\Arg($arg);
        }
        return $sureArgs;
    }
}
