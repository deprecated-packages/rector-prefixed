<?php

declare (strict_types=1);
namespace Rector\PHPUnit\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class TestsNodeAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    public function isInTestClass(\PhpParser\Node $node) : bool
    {
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\ClassLike) {
            return \false;
        }
        return $this->nodeTypeResolver->isObjectTypes($classLike, ['PHPUnit\\Framework\\TestCase', 'PHPUnit_Framework_TestCase']);
    }
    public function isTestClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$classMethod->isPublic()) {
            return \false;
        }
        if ($this->nodeNameResolver->isName($classMethod, 'test*')) {
            return \true;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        return $phpDocInfo->hasByName('test');
    }
    public function isPHPUnitMethodName(\PhpParser\Node $node, string $name) : bool
    {
        if (!$this->isPHPUnitTestCaseCall($node)) {
            return \false;
        }
        /** @var StaticCall|MethodCall $node */
        return $this->nodeNameResolver->isName($node->name, $name);
    }
    public function isPHPUnitTestCaseCall(\PhpParser\Node $node) : bool
    {
        if (!$this->isInTestClass($node)) {
            return \false;
        }
        return $node instanceof \PhpParser\Node\Expr\MethodCall || $node instanceof \PhpParser\Node\Expr\StaticCall;
    }
    /**
     * @param string[] $names
     */
    public function isPHPUnitMethodNames(\PhpParser\Node $node, array $names) : bool
    {
        if (!$this->isPHPUnitTestCaseCall($node)) {
            return \false;
        }
        /** @var MethodCall|StaticCall $node */
        return $this->nodeNameResolver->isNames($node->name, $names);
    }
}
