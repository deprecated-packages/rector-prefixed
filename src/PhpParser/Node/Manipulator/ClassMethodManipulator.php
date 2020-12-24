<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\FuncCallManipulator $funcCallManipulator, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->funcCallManipulator = $funcCallManipulator;
    }
    public function isParameterUsedInClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $isUsedDirectly = (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($param) : bool {
            return $this->betterStandardPrinter->areNodesEqual($node, $param->var);
        });
        if ($isUsedDirectly) {
            return \true;
        }
        /** @var FuncCall[] $compactFuncCalls */
        $compactFuncCalls = $this->betterNodeFinder->find((array) $classMethod->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
                return \false;
            }
            return $this->nodeNameResolver->isName($node, 'compact');
        });
        $arguments = $this->funcCallManipulator->extractArgumentsFromCompactFuncCalls($compactFuncCalls);
        return $this->nodeNameResolver->isNames($param, $arguments);
    }
    public function isNamedConstructor(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->nodeNameResolver->isName($classMethod, \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return \false;
        }
        $classLike = $classMethod->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        return $classMethod->isPrivate() || !$classLike->isFinal() && $classMethod->isProtected();
    }
    public function hasParentMethodOrInterfaceMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, ?string $methodName = null) : bool
    {
        $methodName = $methodName ?? $this->nodeNameResolver->getName($classMethod->name);
        $class = $classMethod->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
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
    public function isStaticClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
                return \false;
            }
            return $this->nodeNameResolver->isName($node, 'this');
        });
    }
    /**
     * @param string[] $possibleNames
     */
    public function addMethodParameterIfMissing(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $type, array $possibleNames) : string
    {
        $classMethodNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if (!$classMethodNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
            // or null?
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        foreach ($classMethodNode->params as $paramNode) {
            if (!$this->nodeTypeResolver->isObjectType($paramNode, $type)) {
                continue;
            }
            $paramName = $this->nodeNameResolver->getName($paramNode);
            if (!\is_string($paramName)) {
                throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
            }
            return $paramName;
        }
        $paramName = $this->resolveName($classMethodNode, $possibleNames);
        $classMethodNode->params[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Param(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($paramName), null, new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($type));
        return $paramName;
    }
    public function isPropertyPromotion(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
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
    private function resolveName(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, array $possibleNames) : string
    {
        foreach ($possibleNames as $possibleName) {
            foreach ($classMethod->params as $paramNode) {
                if ($this->nodeNameResolver->isName($paramNode, $possibleName)) {
                    continue 2;
                }
            }
            return $possibleName;
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
    }
}
