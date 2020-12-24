<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Node;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\NameAndParent;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return NameAndParent[][]
     */
    public function resolveUsedNameNodes(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array
    {
        $this->resolvedNodeNames = [];
        $this->resolveUsedNames($node);
        $this->resolveUsedClassNames($node);
        $this->resolveTraitUseNames($node);
        return $this->resolvedNodeNames;
    }
    private function resolveUsedNames(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        /** @var Name[] $namedNodes */
        $namedNodes = $this->betterNodeFinder->findInstanceOf($node, \_PhpScoperb75b35f52b74\PhpParser\Node\Name::class);
        foreach ($namedNodes as $nameNode) {
            /** node name before becoming FQN - attribute from @see NameResolver */
            $originalName = $nameNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME);
            if (!$originalName instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
                continue;
            }
            $parentNode = $nameNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode === null) {
                throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
            }
            $this->resolvedNodeNames[$originalName->toString()][] = new \_PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\NameAndParent($nameNode, $parentNode);
        }
    }
    private function resolveUsedClassNames(\_PhpScoperb75b35f52b74\PhpParser\Node $searchNode) : void
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
            $this->resolvedNodeNames[$name][] = new \_PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\NameAndParent($classLikeName, $classLike);
        }
    }
    private function resolveTraitUseNames(\_PhpScoperb75b35f52b74\PhpParser\Node $searchNode) : void
    {
        /** @var Identifier[] $identifiers */
        $identifiers = $this->betterNodeFinder->findInstanceOf($searchNode, \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier::class);
        foreach ($identifiers as $identifier) {
            $parentNode = $identifier->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse) {
                continue;
            }
            $this->resolvedNodeNames[$identifier->name][] = new \_PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\NameAndParent($identifier, $parentNode);
        }
    }
}
