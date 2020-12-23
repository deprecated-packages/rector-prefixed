<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\FuncCallManipulator $funcCallManipulator, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->funcCallManipulator = $funcCallManipulator;
    }
    public function isParameterUsedInClassMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Param $param, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $isUsedDirectly = (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use($param) : bool {
            return $this->betterStandardPrinter->areNodesEqual($node, $param->var);
        });
        if ($isUsedDirectly) {
            return \true;
        }
        /** @var FuncCall[] $compactFuncCalls */
        $compactFuncCalls = $this->betterNodeFinder->find((array) $classMethod->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall) {
                return \false;
            }
            return $this->nodeNameResolver->isName($node, 'compact');
        });
        $arguments = $this->funcCallManipulator->extractArgumentsFromCompactFuncCalls($compactFuncCalls);
        return $this->nodeNameResolver->isNames($param, $arguments);
    }
    public function isNamedConstructor(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->nodeNameResolver->isName($classMethod, \_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return \false;
        }
        $classLike = $classMethod->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        return $classMethod->isPrivate() || !$classLike->isFinal() && $classMethod->isProtected();
    }
    public function hasParentMethodOrInterfaceMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, ?string $methodName = null) : bool
    {
        $methodName = $methodName ?? $this->nodeNameResolver->getName($classMethod->name);
        $class = $classMethod->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
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
    public function isStaticClassMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
                return \false;
            }
            return $this->nodeNameResolver->isName($node, 'this');
        });
    }
    /**
     * @param string[] $possibleNames
     */
    public function addMethodParameterIfMissing(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, string $type, array $possibleNames) : string
    {
        $classMethodNode = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if (!$classMethodNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod) {
            // or null?
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        foreach ($classMethodNode->params as $paramNode) {
            if (!$this->nodeTypeResolver->isObjectType($paramNode, $type)) {
                continue;
            }
            $paramName = $this->nodeNameResolver->getName($paramNode);
            if (!\is_string($paramName)) {
                throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
            }
            return $paramName;
        }
        $paramName = $this->resolveName($classMethodNode, $possibleNames);
        $classMethodNode->params[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Param(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable($paramName), null, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified($type));
        return $paramName;
    }
    public function isPropertyPromotion(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
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
    private function resolveName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, array $possibleNames) : string
    {
        foreach ($possibleNames as $possibleName) {
            foreach ($classMethod->params as $paramNode) {
                if ($this->nodeNameResolver->isName($paramNode, $possibleName)) {
                    continue 2;
                }
            }
            return $possibleName;
        }
        throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
    }
}
