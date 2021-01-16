<?php

declare (strict_types=1);
namespace Rector\PhpSpecToPHPUnit\NodeFactory;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use Rector\Core\PhpParser\Node\Manipulator\ConstFetchManipulator;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\NodeNameResolver\NodeNameResolver;
final class AssertMethodCallFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var ConstFetchManipulator
     */
    private $constFetchManipulator;
    /**
     * @var bool
     */
    private $isBoolAssert = \false;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \Rector\Core\PhpParser\Node\Manipulator\ConstFetchManipulator $constFetchManipulator, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeFactory = $nodeFactory;
        $this->constFetchManipulator = $constFetchManipulator;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function createAssertMethod(string $name, \PhpParser\Node\Expr $value, ?\PhpParser\Node\Expr $expected, \PhpParser\Node\Expr\PropertyFetch $testedObjectPropertyFetch) : \PhpParser\Node\Expr\MethodCall
    {
        $this->isBoolAssert = \false;
        // special case with bool!
        if ($expected !== null) {
            $name = $this->resolveBoolMethodName($name, $expected);
        }
        $assetMethodCall = $this->nodeFactory->createMethodCall('this', $name);
        if (!$this->isBoolAssert && $expected) {
            $assetMethodCall->args[] = new \PhpParser\Node\Arg($this->thisToTestedObjectPropertyFetch($expected, $testedObjectPropertyFetch));
        }
        $assetMethodCall->args[] = new \PhpParser\Node\Arg($this->thisToTestedObjectPropertyFetch($value, $testedObjectPropertyFetch));
        return $assetMethodCall;
    }
    private function resolveBoolMethodName(string $name, \PhpParser\Node\Expr $expr) : string
    {
        if (!$this->constFetchManipulator->isBool($expr)) {
            return $name;
        }
        if ($name === 'assertSame') {
            $this->isBoolAssert = \true;
            return $this->constFetchManipulator->isFalse($expr) ? 'assertFalse' : 'assertTrue';
        }
        if ($name === 'assertNotSame') {
            $this->isBoolAssert = \true;
            return $this->constFetchManipulator->isFalse($expr) ? 'assertNotFalse' : 'assertNotTrue';
        }
        return $name;
    }
    private function thisToTestedObjectPropertyFetch(\PhpParser\Node\Expr $expr, \PhpParser\Node\Expr\PropertyFetch $propertyFetch) : \PhpParser\Node\Expr
    {
        if (!$expr instanceof \PhpParser\Node\Expr\Variable) {
            return $expr;
        }
        if (!$this->nodeNameResolver->isName($expr, 'this')) {
            return $expr;
        }
        return $propertyFetch;
    }
}
