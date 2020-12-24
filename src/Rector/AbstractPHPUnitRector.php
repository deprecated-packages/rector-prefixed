<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Rector;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractPHPUnitRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    protected function isTestClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$classMethod->isPublic()) {
            return \false;
        }
        if ($this->isName($classMethod, 'test*')) {
            return \true;
        }
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo::class);
        if ($phpDocInfo instanceof \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return $phpDocInfo->hasByName('test');
        }
        return \false;
    }
    protected function isPHPUnitMethodName(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $name) : bool
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
    protected function isPHPUnitMethodNames(\_PhpScoper0a6b37af0871\PhpParser\Node $node, array $names) : bool
    {
        if (!$this->isPHPUnitTestCaseCall($node)) {
            return \false;
        }
        /** @var MethodCall|StaticCall $node */
        return $this->isNames($node->name, $names);
    }
    protected function isInTestClass(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        $classLike = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \false;
        }
        return $this->isObjectTypes($classLike, ['_PhpScoper0a6b37af0871\\PHPUnit\\Framework\\TestCase', 'PHPUnit_Framework_TestCase']);
    }
    /**
     * @param StaticCall|MethodCall $node
     * @return StaticCall|MethodCall
     */
    protected function createPHPUnitCallWithName(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $name) : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        return $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall ? new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall($node->var, $name) : new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall($node->class, $name);
    }
    protected function isPHPUnitTestCaseCall(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        if (!$this->isInTestClass($node)) {
            return \false;
        }
        return $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall || $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
    }
}
