<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\FamilyTree\NodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a6b37af0871\Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class PropertyUsageAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var FamilyRelationsAnalyzer
     */
    private $familyRelationsAnalyzer;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a6b37af0871\Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer $familyRelationsAnalyzer, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->familyRelationsAnalyzer = $familyRelationsAnalyzer;
        $this->nodeRepository = $nodeRepository;
    }
    public function isPropertyFetchedInChildClass(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : bool
    {
        $className = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return \false;
        }
        $classLike = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ && $classLike->isFinal()) {
            return \false;
        }
        $propertyName = $this->nodeNameResolver->getName($property);
        $childrenClassNames = $this->familyRelationsAnalyzer->getChildrenOfClass($className);
        foreach ($childrenClassNames as $childClassName) {
            $childClass = $this->nodeRepository->findClass($childClassName);
            if ($childClass === null) {
                continue;
            }
            $isPropertyFetched = (bool) $this->betterNodeFinder->findFirst((array) $childClass->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($propertyName) : bool {
                return $this->nodeNameResolver->isLocalPropertyFetchNamed($node, $propertyName);
            });
            if ($isPropertyFetched) {
                return \true;
            }
        }
        return \false;
    }
}
