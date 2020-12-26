<?php

declare (strict_types=1);
namespace Rector\Core\Rector;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractPHPUnitRector extends \Rector\Core\Rector\AbstractRector
{
    protected function isTestClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$classMethod->isPublic()) {
            return \false;
        }
        if ($this->isName($classMethod, 'test*')) {
            return \true;
        }
        $phpDocInfo = $classMethod->getAttribute(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo::class);
        if ($phpDocInfo instanceof \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return $phpDocInfo->hasByName('test');
        }
        return \false;
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
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \false;
        }
        return $this->isObjectTypes($classLike, ['RectorPrefix2020DecSat\\PHPUnit\\Framework\\TestCase', 'PHPUnit_Framework_TestCase']);
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
