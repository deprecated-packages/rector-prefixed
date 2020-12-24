<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\ChildPopulator;

use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\ChangesReporting\Collector\RectorChangeCollector;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\NewType;
final class ChildParamPopulator extends \_PhpScopere8e811afab72\Rector\TypeDeclaration\ChildPopulator\AbstractChildPopulator
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var RectorChangeCollector
     */
    private $rectorChangeCollector;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector, \_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->rectorChangeCollector = $rectorChangeCollector;
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * Add typehint to all children
     * @param ClassMethod|Function_ $functionLike
     */
    public function populateChildClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike, int $position, \_PhpScopere8e811afab72\PHPStan\Type\Type $paramType) : void
    {
        if (!$functionLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            return;
        }
        /** @var string|null $className */
        $className = $functionLike->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        // anonymous class
        if ($className === null) {
            return;
        }
        $childrenClassLikes = $this->nodeRepository->findClassesAndInterfacesByType($className);
        // update their methods as well
        foreach ($childrenClassLikes as $childClassLike) {
            if ($childClassLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
                $usedTraits = $this->nodeRepository->findUsedTraitsInClass($childClassLike);
                foreach ($usedTraits as $trait) {
                    $this->addParamTypeToMethod($trait, $position, $functionLike, $paramType);
                }
            }
            $this->addParamTypeToMethod($childClassLike, $position, $functionLike, $paramType);
        }
    }
    private function addParamTypeToMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike, int $position, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\PHPStan\Type\Type $paramType) : void
    {
        $methodName = $this->nodeNameResolver->getName($classMethod);
        $currentClassMethod = $classLike->getMethod($methodName);
        if ($currentClassMethod === null) {
            return;
        }
        if (!isset($currentClassMethod->params[$position])) {
            return;
        }
        $paramNode = $currentClassMethod->params[$position];
        // already has a type
        if ($paramNode->type !== null) {
            return;
        }
        $resolvedChildType = $this->resolveChildTypeNode($paramType);
        if ($resolvedChildType === null) {
            return;
        }
        // let the method know it was changed now
        $paramNode->type = $resolvedChildType;
        $paramNode->type->setAttribute(\_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\NewType::HAS_NEW_INHERITED_TYPE, \true);
        $this->rectorChangeCollector->notifyNodeFileInfo($paramNode);
    }
}
