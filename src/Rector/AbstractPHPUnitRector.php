<?php

declare (strict_types=1);
namespace Rector\Core\Rector;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\PHPUnit\NodeAnalyzer\TestsNodeAnalyzer;
abstract class AbstractPHPUnitRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var TestsNodeAnalyzer
     */
    private $testsNodeAnalyzer;
    /**
     * @required
     */
    public function autowireAbstractPHPUnitRector(\Rector\PHPUnit\NodeAnalyzer\TestsNodeAnalyzer $testsNodeAnalyzer) : void
    {
        $this->testsNodeAnalyzer = $testsNodeAnalyzer;
    }
    protected function isTestClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$classMethod->isPublic()) {
            return \false;
        }
        if ($this->isName($classMethod, 'test*')) {
            return \true;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        return $phpDocInfo->hasByName('test');
    }
    protected function isPHPUnitMethodName(\PhpParser\Node $node, string $name) : bool
    {
        if (!$this->isPHPUnitTestCaseCall($node)) {
            return \false;
        }
        /** @var StaticCall|MethodCall $node */
        return $this->isName($node->name, $name);
    }
    /**
     * @param string[] $names
     */
    protected function isPHPUnitMethodNames(\PhpParser\Node $node, array $names) : bool
    {
        if (!$this->isPHPUnitTestCaseCall($node)) {
            return \false;
        }
        /** @var MethodCall|StaticCall $node */
        return $this->isNames($node->name, $names);
    }
    protected function isInTestClass(\PhpParser\Node $node) : bool
    {
        return $this->testsNodeAnalyzer->isInTestClass($node);
    }
    /**
     * @param StaticCall|MethodCall $node
     * @return StaticCall|MethodCall
     */
    protected function createPHPUnitCallWithName(\PhpParser\Node $node, string $name) : \PhpParser\Node
    {
        return $node instanceof \PhpParser\Node\Expr\MethodCall ? new \PhpParser\Node\Expr\MethodCall($node->var, $name) : new \PhpParser\Node\Expr\StaticCall($node->class, $name);
    }
    protected function isPHPUnitTestCaseCall(\PhpParser\Node $node) : bool
    {
        if (!$this->isInTestClass($node)) {
            return \false;
        }
        return $node instanceof \PhpParser\Node\Expr\MethodCall || $node instanceof \PhpParser\Node\Expr\StaticCall;
    }
}
