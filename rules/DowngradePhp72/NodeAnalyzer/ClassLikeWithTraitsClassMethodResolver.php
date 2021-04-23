<?php

declare (strict_types=1);
namespace Rector\DowngradePhp72\NodeAnalyzer;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class ClassLikeWithTraitsClassMethodResolver
{
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * @return ClassMethod[]
     */
    public function resolve(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $scope = $class->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            return [];
        }
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            return [];
        }
        $classMethods = [];
        foreach ($classReflection->getAncestors() as $ancestorClassReflection) {
            $classLike = $this->nodeRepository->findClassLike($ancestorClassReflection->getName());
            if (!$classLike instanceof \PhpParser\Node\Stmt\ClassLike) {
                continue;
            }
            $classMethods = \array_merge($classMethods, $classLike->getMethods());
        }
        return $classMethods;
    }
}
