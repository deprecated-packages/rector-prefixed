<?php

declare (strict_types=1);
namespace Rector\CodeQuality\NodeAnalyzer;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Node\Value\ValueResolver;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class CallableClassMethodMatcher
{
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->valueResolver = $valueResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeRepository = $nodeRepository;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param Variable|PropertyFetch $objectExpr
     */
    public function match(\PhpParser\Node\Expr $objectExpr, \PhpParser\Node\Scalar\String_ $string) : ?\PhpParser\Node\Stmt\ClassMethod
    {
        $methodName = $this->valueResolver->getValue($string);
        if (!\is_string($methodName)) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $objectType = $this->nodeTypeResolver->resolve($objectExpr);
        $objectType = $this->popFirstObjectType($objectType);
        if ($objectType instanceof \PHPStan\Type\ObjectType) {
            $class = $this->nodeRepository->findClass($objectType->getClassName());
            if (!$class instanceof \PhpParser\Node\Stmt\Class_) {
                return null;
            }
            $classMethod = $class->getMethod($methodName);
            if (!$classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
                return null;
            }
            if ($this->nodeNameResolver->isName($objectExpr, 'this')) {
                return $classMethod;
            }
            // is public method of another service
            if ($classMethod->isPublic()) {
                return $classMethod;
            }
        }
        return null;
    }
    private function popFirstObjectType(\PHPStan\Type\Type $type) : \PHPStan\Type\Type
    {
        if ($type instanceof \PHPStan\Type\UnionType) {
            foreach ($type->getTypes() as $unionedType) {
                if (!$unionedType instanceof \PHPStan\Type\ObjectType) {
                    continue;
                }
                return $unionedType;
            }
        }
        return $type;
    }
}
