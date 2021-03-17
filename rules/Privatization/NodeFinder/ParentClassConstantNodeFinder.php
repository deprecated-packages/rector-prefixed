<?php

declare (strict_types=1);
namespace Rector\Privatization\NodeFinder;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeCollector\ScopeResolver\ParentClassScopeResolver;
final class ParentClassConstantNodeFinder
{
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    /**
     * @var ParentClassScopeResolver
     */
    private $parentClassScopeResolver;
    public function __construct(\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \Rector\NodeCollector\ScopeResolver\ParentClassScopeResolver $parentClassScopeResolver)
    {
        $this->nodeRepository = $nodeRepository;
        $this->parentClassScopeResolver = $parentClassScopeResolver;
    }
    public function find(string $class, string $constant) : ?\PhpParser\Node\Stmt\ClassConst
    {
        $classNode = $this->nodeRepository->findClass($class);
        if (!$classNode instanceof \PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $parentClassName = $this->parentClassScopeResolver->resolveParentClassName($classNode);
        if ($parentClassName === null) {
            return null;
        }
        return $this->nodeRepository->findClassConstant($parentClassName, $constant);
    }
}
