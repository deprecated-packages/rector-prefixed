<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Node;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\UseUse;
use _PhpScopere8e811afab72\Rector\CodingStyle\ValueObject\NameAndParent;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class UseManipulator
{
    /**
     * @var NameAndParent[][]
     */
    private $resolvedNodeNames = [];
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return NameAndParent[][]
     */
    public function resolveUsedNameNodes(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        $this->resolvedNodeNames = [];
        $this->resolveUsedNames($node);
        $this->resolveUsedClassNames($node);
        $this->resolveTraitUseNames($node);
        return $this->resolvedNodeNames;
    }
    private function resolveUsedNames(\_PhpScopere8e811afab72\PhpParser\Node $node) : void
    {
        /** @var Name[] $namedNodes */
        $namedNodes = $this->betterNodeFinder->findInstanceOf($node, \_PhpScopere8e811afab72\PhpParser\Node\Name::class);
        foreach ($namedNodes as $nameNode) {
            /** node name before becoming FQN - attribute from @see NameResolver */
            $originalName = $nameNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME);
            if (!$originalName instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
                continue;
            }
            $parentNode = $nameNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode === null) {
                throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
            }
            $this->resolvedNodeNames[$originalName->toString()][] = new \_PhpScopere8e811afab72\Rector\CodingStyle\ValueObject\NameAndParent($nameNode, $parentNode);
        }
    }
    private function resolveUsedClassNames(\_PhpScopere8e811afab72\PhpParser\Node $searchNode) : void
    {
        /** @var ClassLike[] $classLikes */
        $classLikes = $this->betterNodeFinder->findClassLikes([$searchNode]);
        foreach ($classLikes as $classLike) {
            $classLikeName = $classLike->name;
            if ($classLikeName === null) {
                continue;
            }
            $name = $this->nodeNameResolver->getName($classLikeName);
            if ($name === null) {
                continue;
            }
            $this->resolvedNodeNames[$name][] = new \_PhpScopere8e811afab72\Rector\CodingStyle\ValueObject\NameAndParent($classLikeName, $classLike);
        }
    }
    private function resolveTraitUseNames(\_PhpScopere8e811afab72\PhpParser\Node $searchNode) : void
    {
        /** @var Identifier[] $identifiers */
        $identifiers = $this->betterNodeFinder->findInstanceOf($searchNode, \_PhpScopere8e811afab72\PhpParser\Node\Identifier::class);
        foreach ($identifiers as $identifier) {
            $parentNode = $identifier->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\UseUse) {
                continue;
            }
            $this->resolvedNodeNames[$identifier->name][] = new \_PhpScopere8e811afab72\Rector\CodingStyle\ValueObject\NameAndParent($identifier, $parentNode);
        }
    }
}
