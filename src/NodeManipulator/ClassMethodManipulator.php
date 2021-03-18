<?php

declare (strict_types=1);
namespace Rector\Core\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Type\ObjectType;
use Rector\Core\Exception\ShouldNotHappenException;
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
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
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
        if ($classMethod->isPrivate()) {
            return \true;
        }
        if ($classLike->isFinal()) {
            return \false;
        }
        return $classMethod->isProtected();
    }
    public function hasParentMethodOrInterfaceMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, ?string $methodName = null) : bool
    {
        $methodName = $methodName ?? $this->nodeNameResolver->getName($classMethod->name);
        if ($methodName === null) {
            return \false;
        }
        $scope = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            return \false;
        }
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            return \false;
        }
        foreach ($classReflection->getParents() as $parentClassReflection) {
            if ($parentClassReflection->hasMethod($methodName)) {
                return \true;
            }
        }
        foreach ($classReflection->getInterfaces() as $interfaceReflection) {
            if ($interfaceReflection->hasMethod($methodName)) {
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
    public function addMethodParameterIfMissing(\PhpParser\Node $node, \PHPStan\Type\ObjectType $objectType, array $possibleNames) : string
    {
        $classMethodNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if (!$classMethodNode instanceof \PhpParser\Node\Stmt\ClassMethod) {
            // or null?
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        foreach ($classMethodNode->params as $paramNode) {
            if (!$this->nodeTypeResolver->isObjectType($paramNode, $objectType)) {
                continue;
            }
            $paramName = $this->nodeNameResolver->getName($paramNode);
            if (!\is_string($paramName)) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            return $paramName;
        }
        $paramName = $this->resolveName($classMethodNode, $possibleNames);
        $classMethodNode->params[] = new \PhpParser\Node\Param(new \PhpParser\Node\Expr\Variable($paramName), null, new \PhpParser\Node\Name\FullyQualified($objectType->getClassName()));
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
