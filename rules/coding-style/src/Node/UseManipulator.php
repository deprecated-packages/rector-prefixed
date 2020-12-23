<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodingStyle\Node;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\UseUse;
use _PhpScoper0a2ac50786fa\Rector\CodingStyle\ValueObject\NameAndParent;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return NameAndParent[][]
     */
    public function resolveUsedNameNodes(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : array
    {
        $this->resolvedNodeNames = [];
        $this->resolveUsedNames($node);
        $this->resolveUsedClassNames($node);
        $this->resolveTraitUseNames($node);
        return $this->resolvedNodeNames;
    }
    private function resolveUsedNames(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : void
    {
        /** @var Name[] $namedNodes */
        $namedNodes = $this->betterNodeFinder->findInstanceOf($node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Name::class);
        foreach ($namedNodes as $nameNode) {
            /** node name before becoming FQN - attribute from @see NameResolver */
            $originalName = $nameNode->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME);
            if (!$originalName instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name) {
                continue;
            }
            $parentNode = $nameNode->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode === null) {
                throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
            }
            $this->resolvedNodeNames[$originalName->toString()][] = new \_PhpScoper0a2ac50786fa\Rector\CodingStyle\ValueObject\NameAndParent($nameNode, $parentNode);
        }
    }
    private function resolveUsedClassNames(\_PhpScoper0a2ac50786fa\PhpParser\Node $searchNode) : void
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
            $this->resolvedNodeNames[$name][] = new \_PhpScoper0a2ac50786fa\Rector\CodingStyle\ValueObject\NameAndParent($classLikeName, $classLike);
        }
    }
    private function resolveTraitUseNames(\_PhpScoper0a2ac50786fa\PhpParser\Node $searchNode) : void
    {
        /** @var Identifier[] $identifiers */
        $identifiers = $this->betterNodeFinder->findInstanceOf($searchNode, \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier::class);
        foreach ($identifiers as $identifier) {
            $parentNode = $identifier->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\UseUse) {
                continue;
            }
            $this->resolvedNodeNames[$identifier->name][] = new \_PhpScoper0a2ac50786fa\Rector\CodingStyle\ValueObject\NameAndParent($identifier, $parentNode);
        }
    }
}
