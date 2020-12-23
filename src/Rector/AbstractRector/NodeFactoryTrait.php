<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\NodeFactory;
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
    public function autowireNodeFactoryTrait(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory) : void
    {
        $this->nodeFactory = $nodeFactory;
    }
    /**
     * @param Expr[]|Arg[] $args
     */
    protected function createStaticCall(string $class, string $method, array $args = []) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall
    {
        $args = $this->wrapToArg($args);
        if (\in_array($class, ['self', 'parent', 'static'], \true)) {
            $class = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($class);
        } else {
            $class = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified($class);
        }
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall($class, $method, $args);
    }
    /**
     * @param Expr[] $exprsToConcat
     */
    protected function createConcat(array $exprsToConcat) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat
    {
        return $this->nodeFactory->createConcat($exprsToConcat);
    }
    protected function createClassConstFetch(string $class, string $constant) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->nodeFactory->createClassConstFetch($class, $constant);
    }
    protected function createNull() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ConstFetch
    {
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('null'));
    }
    protected function createFalse() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ConstFetch
    {
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('false'));
    }
    protected function createTrue() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ConstFetch
    {
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('true'));
    }
    /**
     * @param mixed $argument
     */
    protected function createArg($argument) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg
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
    protected function createArray(array $nodes) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_
    {
        return $this->nodeFactory->createArray($nodes);
    }
    /**
     * @param mixed[] $arguments
     */
    protected function createFuncCall(string $name, array $arguments = []) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall
    {
        return $this->nodeFactory->createFuncCall($name, $arguments);
    }
    protected function createClassConstantReference(string $class) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->nodeFactory->createClassConstReference($class);
    }
    protected function createPropertyAssignmentWithExpr(string $propertyName, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign
    {
        return $this->nodeFactory->createPropertyAssignmentWithExpr($propertyName, $expr);
    }
    /**
     * @param string|Expr $variable
     * @param mixed[] $arguments
     */
    protected function createMethodCall($variable, string $method, array $arguments = []) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
    {
        return $this->nodeFactory->createMethodCall($variable, $method, $arguments);
    }
    /**
     * @param mixed[] $arguments
     */
    protected function createLocalMethodCall(string $method, array $arguments = []) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
    {
        $variable = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable('this');
        return $this->nodeFactory->createMethodCall($variable, $method, $arguments);
    }
    /**
     * @param string|Expr $variable
     */
    protected function createPropertyFetch($variable, string $property) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch
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
            if ($arg instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg) {
                $sureArgs[] = $arg;
                continue;
            }
            $sureArgs[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($arg);
        }
        return $sureArgs;
    }
}
