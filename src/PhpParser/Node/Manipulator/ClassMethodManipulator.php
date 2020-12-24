<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class ClassMethodManipulator
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var FuncCallManipulator
     */
    private $funcCallManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\FuncCallManipulator $funcCallManipulator, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->funcCallManipulator = $funcCallManipulator;
    }
    public function isParameterUsedInClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Param $param, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $isUsedDirectly = (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($param) : bool {
            return $this->betterStandardPrinter->areNodesEqual($node, $param->var);
        });
        if ($isUsedDirectly) {
            return \true;
        }
        /** @var FuncCall[] $compactFuncCalls */
        $compactFuncCalls = $this->betterNodeFinder->find((array) $classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
                return \false;
            }
            return $this->nodeNameResolver->isName($node, 'compact');
        });
        $arguments = $this->funcCallManipulator->extractArgumentsFromCompactFuncCalls($compactFuncCalls);
        return $this->nodeNameResolver->isNames($param, $arguments);
    }
    public function isNamedConstructor(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->nodeNameResolver->isName($classMethod, \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return \false;
        }
        $classLike = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        return $classMethod->isPrivate() || !$classLike->isFinal() && $classMethod->isProtected();
    }
    public function hasParentMethodOrInterfaceMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, ?string $methodName = null) : bool
    {
        $methodName = $methodName ?? $this->nodeNameResolver->getName($classMethod->name);
        $class = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if (!\is_string($class)) {
            return \false;
        }
        if (!\class_exists($class)) {
            return \false;
        }
        if (!\is_string($methodName)) {
            return \false;
        }
        if ($this->isMethodInParent($class, $methodName)) {
            return \true;
        }
        $implementedInterfaces = (array) \class_implements($class);
        foreach ($implementedInterfaces as $implementedInterface) {
            /** @var string $implementedInterface */
            if (\method_exists($implementedInterface, $methodName)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * Is method actually static, or has some $this-> calls?
     */
    public function isStaticClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
                return \false;
            }
            return $this->nodeNameResolver->isName($node, 'this');
        });
    }
    /**
     * @param string[] $possibleNames
     */
    public function addMethodParameterIfMissing(\_PhpScopere8e811afab72\PhpParser\Node $node, string $type, array $possibleNames) : string
    {
        $classMethodNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if (!$classMethodNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            // or null?
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        foreach ($classMethodNode->params as $paramNode) {
            if (!$this->nodeTypeResolver->isObjectType($paramNode, $type)) {
                continue;
            }
            $paramName = $this->nodeNameResolver->getName($paramNode);
            if (!\is_string($paramName)) {
                throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
            }
            return $paramName;
        }
        $paramName = $this->resolveName($classMethodNode, $possibleNames);
        $classMethodNode->params[] = new \_PhpScopere8e811afab72\PhpParser\Node\Param(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($paramName), null, new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($type));
        return $paramName;
    }
    public function isPropertyPromotion(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        foreach ((array) $classMethod->params as $param) {
            /** @var Param $param */
            if ($param->flags !== 0) {
                return \true;
            }
        }
        return \false;
    }
    private function isMethodInParent(string $class, string $method) : bool
    {
        foreach ((array) \class_parents($class) as $parentClass) {
            /** @var string $parentClass */
            if (\method_exists($parentClass, $method)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param string[] $possibleNames
     */
    private function resolveName(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, array $possibleNames) : string
    {
        foreach ($possibleNames as $possibleName) {
            foreach ($classMethod->params as $paramNode) {
                if ($this->nodeNameResolver->isName($paramNode, $possibleName)) {
                    continue 2;
                }
            }
            return $possibleName;
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
    }
}
