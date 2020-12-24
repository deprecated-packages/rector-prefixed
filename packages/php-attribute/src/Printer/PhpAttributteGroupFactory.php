<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PhpAttribute\Printer;

use _PhpScoper2a4e7ab1ecbc\PhpParser\BuilderHelpers;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Attribute;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\AttributeGroup;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\Rector\PhpAttribute\Contract\ManyPhpAttributableTagNodeInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
final class PhpAttributteGroupFactory
{
    /**
     * @var string
     */
    public const TBA = 'TBA';
    /**
     * @param PhpAttributableTagNodeInterface[] $phpAttributableTagNodes
     * @return AttributeGroup[]
     */
    public function create(array $phpAttributableTagNodes) : array
    {
        $attributeGroups = [];
        foreach ($phpAttributableTagNodes as $phpAttributableTagNode) {
            $currentAttributeGroups = $this->printPhpAttributableTagNode($phpAttributableTagNode);
            $attributeGroups = \array_merge($attributeGroups, $currentAttributeGroups);
        }
        return $attributeGroups;
    }
    /**
     * @return Arg[]
     */
    public function printItemsToAttributeArgs(\_PhpScoper2a4e7ab1ecbc\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface $phpAttributableTagNode) : array
    {
        $items = $phpAttributableTagNode->getAttributableItems();
        return $this->createArgsFromItems($items);
    }
    /**
     * @return AttributeGroup[]
     */
    private function printPhpAttributableTagNode(\_PhpScoper2a4e7ab1ecbc\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface $phpAttributableTagNode) : array
    {
        $args = $this->printItemsToAttributeArgs($phpAttributableTagNode);
        $attributeClassName = $this->resolveAttributeClassName($phpAttributableTagNode);
        $attributeGroups = [];
        $attributeGroups[] = $this->createAttributeGroupFromNameAndArgs($attributeClassName, $args);
        if ($phpAttributableTagNode instanceof \_PhpScoper2a4e7ab1ecbc\Rector\PhpAttribute\Contract\ManyPhpAttributableTagNodeInterface) {
            foreach ($phpAttributableTagNode->provide() as $shortName => $items) {
                $args = $this->createArgsFromItems($items);
                $name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name($shortName);
                $attributeGroups[] = $this->createAttributeGroupFromNameAndArgs($name, $args);
            }
        }
        return $attributeGroups;
    }
    /**
     * @param mixed[] $items
     * @return Arg[]
     */
    private function createArgsFromItems(array $items, ?string $silentKey = null) : array
    {
        $args = [];
        if ($silentKey !== null && isset($items[$silentKey])) {
            $silentValue = \_PhpScoper2a4e7ab1ecbc\PhpParser\BuilderHelpers::normalizeValue($items[$silentKey]);
            $args[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($silentValue);
            unset($items[$silentKey]);
        }
        if ($this->isArrayArguments($items)) {
            foreach ($items as $key => $value) {
                $argumentName = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier($key);
                $value = \_PhpScoper2a4e7ab1ecbc\PhpParser\BuilderHelpers::normalizeValue($value);
                $args[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($value, \false, \false, [], $argumentName);
            }
        } else {
            foreach ($items as $value) {
                $value = \_PhpScoper2a4e7ab1ecbc\PhpParser\BuilderHelpers::normalizeValue($value);
                $args[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($value);
            }
        }
        return $args;
    }
    private function resolveAttributeClassName(\_PhpScoper2a4e7ab1ecbc\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface $phpAttributableTagNode) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name
    {
        if ($phpAttributableTagNode->getAttributeClassName() !== self::TBA) {
            return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified($phpAttributableTagNode->getAttributeClassName());
        }
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name($phpAttributableTagNode->getShortName());
    }
    /**
     * @param Arg[] $args
     */
    private function createAttributeGroupFromNameAndArgs(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name $name, array $args) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\AttributeGroup
    {
        $attribute = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Attribute($name, $args);
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\AttributeGroup([$attribute]);
    }
    /**
     * @param mixed[] $items
     */
    private function isArrayArguments(array $items) : bool
    {
        foreach (\array_keys($items) as $key) {
            if (!\is_int($key)) {
                return \true;
            }
        }
        return \false;
    }
}
