<?php

declare(strict_types=1);

namespace Rector\CodingStyle\Node;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\UseUse;
use Rector\CodingStyle\ValueObject\NameAndParent;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;

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

    public function __construct(BetterNodeFinder $betterNodeFinder, NodeNameResolver $nodeNameResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }

    /**
     * @return NameAndParent[][]
     */
    public function resolveUsedNameNodes(Node $node): array
    {
        $this->resolvedNodeNames = [];

        $this->resolveUsedNames($node);
        $this->resolveUsedClassNames($node);
        $this->resolveTraitUseNames($node);

        return $this->resolvedNodeNames;
    }

    /**
     * @return void
     */
    private function resolveUsedNames(Node $node)
    {
        /** @var Name[] $namedNodes */
        $namedNodes = $this->betterNodeFinder->findInstanceOf($node, Name::class);

        foreach ($namedNodes as $namedNode) {
            /** node name before becoming FQN - attribute from @see NameResolver */
            $originalName = $namedNode->getAttribute(AttributeKey::ORIGINAL_NAME);
            if (! $originalName instanceof Name) {
                continue;
            }

            $parentNode = $namedNode->getAttribute(AttributeKey::PARENT_NODE);
            if (! $parentNode instanceof Node) {
                throw new ShouldNotHappenException();
            }

            $this->resolvedNodeNames[$originalName->toString()][] = new NameAndParent($namedNode, $parentNode);
        }
    }

    /**
     * @return void
     */
    private function resolveUsedClassNames(Node $searchNode)
    {
        /** @var ClassLike[] $classLikes */
        $classLikes = $this->betterNodeFinder->findClassLikes([$searchNode]);

        foreach ($classLikes as $classLike) {
            $classLikeName = $classLike->name;
            if (! $classLikeName instanceof Identifier) {
                continue;
            }

            $name = $this->nodeNameResolver->getName($classLikeName);
            if ($name === null) {
                continue;
            }

            $this->resolvedNodeNames[$name][] = new NameAndParent($classLikeName, $classLike);
        }
    }

    /**
     * @return void
     */
    private function resolveTraitUseNames(Node $searchNode)
    {
        /** @var Identifier[] $identifiers */
        $identifiers = $this->betterNodeFinder->findInstanceOf($searchNode, Identifier::class);

        foreach ($identifiers as $identifier) {
            $parentNode = $identifier->getAttribute(AttributeKey::PARENT_NODE);
            if (! $parentNode instanceof UseUse) {
                continue;
            }

            $this->resolvedNodeNames[$identifier->name][] = new NameAndParent($identifier, $parentNode);
        }
    }
}
