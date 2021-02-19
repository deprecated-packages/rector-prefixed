<?php

declare (strict_types=1);
namespace Rector\Core\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Comparing\NodeComparator;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\ValueObject\MethodName;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class ClassMethodManipulator
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeComparator
     */
    private $nodeComparator;
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
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\Core\NodeManipulator\FuncCallManipulator $funcCallManipulator, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\Core\PhpParser\Comparing\NodeComparator $nodeComparator)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->funcCallManipulator = $funcCallManipulator;
        $this->nodeComparator = $nodeComparator;
    }
    public function isParameterUsedInClassMethod(\PhpParser\Node\Param $param, \PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $isUsedDirectly = (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\PhpParser\Node $node) use($param) : bool {
            return $this->nodeComparator->areNodesEqual($node, $param->var);
        });
        if ($isUsedDirectly) {
            return \true;
        }
        /** @var FuncCall[] $compactFuncCalls */
        $compactFuncCalls = $this->betterNodeFinder->find((array) $classMethod->stmts, function (\PhpParser\Node $node) : bool {
            if (!$node instanceof \PhpParser\Node\Expr\FuncCall) {
                return \false;
            }
            return $this->nodeNameResolver->isName($node, 'compact');
        });
        $arguments = $this->funcCallManipulator->extractArgumentsFromCompactFuncCalls($compactFuncCalls);
        return $this->nodeNameResolver->isNames($param, $arguments);
    }
    public function isNamedConstructor(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->nodeNameResolver->isName($classMethod, \Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return \false;
        }
        $classLike = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        return $classMethod->isPrivate() || !$classLike->isFinal() && $classMethod->isProtected();
    }
    public function hasParentMethodOrInterfaceMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, ?string $methodName = null) : bool
    {
        $methodName = $methodName ?? $this->nodeNameResolver->getName($classMethod->name);
        $class = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
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
    public function isStaticClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\PhpParser\Node $node) : bool {
            if (!$node instanceof \PhpParser\Node\Expr\Variable) {
                return \false;
            }
            return $this->nodeNameResolver->isName($node, 'this');
        });
    }
    /**
     * @param string[] $possibleNames
     */
    public function addMethodParameterIfMissing(\PhpParser\Node $node, string $type, array $possibleNames) : string
    {
        $classMethodNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if (!$classMethodNode instanceof \PhpParser\Node\Stmt\ClassMethod) {
            // or null?
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        foreach ($classMethodNode->params as $paramNode) {
            if (!$this->nodeTypeResolver->isObjectType($paramNode, $type)) {
                continue;
            }
            $paramName = $this->nodeNameResolver->getName($paramNode);
            if (!\is_string($paramName)) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            return $paramName;
        }
        $paramName = $this->resolveName($classMethodNode, $possibleNames);
        $classMethodNode->params[] = new \PhpParser\Node\Param(new \PhpParser\Node\Expr\Variable($paramName), null, new \PhpParser\Node\Name\FullyQualified($type));
        return $paramName;
    }
    public function isPropertyPromotion(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        foreach ($classMethod->params as $param) {
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
    private function resolveName(\PhpParser\Node\Stmt\ClassMethod $classMethod, array $possibleNames) : string
    {
        foreach ($possibleNames as $possibleName) {
            foreach ($classMethod->params as $paramNode) {
                if ($this->nodeNameResolver->isName($paramNode, $possibleName)) {
                    continue 2;
                }
            }
            return $possibleName;
        }
        throw new \Rector\Core\Exception\ShouldNotHappenException();
    }
}
