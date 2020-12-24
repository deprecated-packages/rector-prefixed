<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\ChildPopulator;

use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\ChangesReporting\Collector\RectorChangeCollector;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\ValueObject\NewType;
final class ChildParamPopulator extends \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\ChildPopulator\AbstractChildPopulator
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector, \_PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->rectorChangeCollector = $rectorChangeCollector;
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * Add typehint to all children
     * @param ClassMethod|Function_ $functionLike
     */
    public function populateChildClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike, int $position, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $paramType) : void
    {
        if (!$functionLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod) {
            return;
        }
        /** @var string|null $className */
        $className = $functionLike->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        // anonymous class
        if ($className === null) {
            return;
        }
        $childrenClassLikes = $this->nodeRepository->findClassesAndInterfacesByType($className);
        // update their methods as well
        foreach ($childrenClassLikes as $childClassLike) {
            if ($childClassLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
                $usedTraits = $this->nodeRepository->findUsedTraitsInClass($childClassLike);
                foreach ($usedTraits as $trait) {
                    $this->addParamTypeToMethod($trait, $position, $functionLike, $paramType);
                }
            }
            $this->addParamTypeToMethod($childClassLike, $position, $functionLike, $paramType);
        }
    }
    private function addParamTypeToMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike $classLike, int $position, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $paramType) : void
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
        $paramNode->type->setAttribute(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\ValueObject\NewType::HAS_NEW_INHERITED_TYPE, \true);
        $this->rectorChangeCollector->notifyNodeFileInfo($paramNode);
    }
}
