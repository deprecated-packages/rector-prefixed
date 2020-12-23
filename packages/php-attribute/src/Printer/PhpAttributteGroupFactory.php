<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PhpAttribute\Printer;

use _PhpScoper0a2ac50786fa\PhpParser\BuilderHelpers;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Attribute;
use _PhpScoper0a2ac50786fa\PhpParser\Node\AttributeGroup;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\Rector\PhpAttribute\Contract\ManyPhpAttributableTagNodeInterface;
use _PhpScoper0a2ac50786fa\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
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
    public function printItemsToAttributeArgs(\_PhpScoper0a2ac50786fa\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface $phpAttributableTagNode) : array
    {
        $items = $phpAttributableTagNode->getAttributableItems();
        return $this->createArgsFromItems($items);
    }
    /**
     * @return AttributeGroup[]
     */
    private function printPhpAttributableTagNode(\_PhpScoper0a2ac50786fa\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface $phpAttributableTagNode) : array
    {
        $args = $this->printItemsToAttributeArgs($phpAttributableTagNode);
        $attributeClassName = $this->resolveAttributeClassName($phpAttributableTagNode);
        $attributeGroups = [];
        $attributeGroups[] = $this->createAttributeGroupFromNameAndArgs($attributeClassName, $args);
        if ($phpAttributableTagNode instanceof \_PhpScoper0a2ac50786fa\Rector\PhpAttribute\Contract\ManyPhpAttributableTagNodeInterface) {
            foreach ($phpAttributableTagNode->provide() as $shortName => $items) {
                $args = $this->createArgsFromItems($items);
                $name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($shortName);
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
            $silentValue = \_PhpScoper0a2ac50786fa\PhpParser\BuilderHelpers::normalizeValue($items[$silentKey]);
            $args[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($silentValue);
            unset($items[$silentKey]);
        }
        if ($this->isArrayArguments($items)) {
            foreach ($items as $key => $value) {
                $argumentName = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier($key);
                $value = \_PhpScoper0a2ac50786fa\PhpParser\BuilderHelpers::normalizeValue($value);
                $args[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($value, \false, \false, [], $argumentName);
            }
        } else {
            foreach ($items as $value) {
                $value = \_PhpScoper0a2ac50786fa\PhpParser\BuilderHelpers::normalizeValue($value);
                $args[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($value);
            }
        }
        return $args;
    }
    private function resolveAttributeClassName(\_PhpScoper0a2ac50786fa\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface $phpAttributableTagNode) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Name
    {
        if ($phpAttributableTagNode->getAttributeClassName() !== self::TBA) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified($phpAttributableTagNode->getAttributeClassName());
        }
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($phpAttributableTagNode->getShortName());
    }
    /**
     * @param Arg[] $args
     */
    private function createAttributeGroupFromNameAndArgs(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $name, array $args) : \_PhpScoper0a2ac50786fa\PhpParser\Node\AttributeGroup
    {
        $attribute = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Attribute($name, $args);
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\AttributeGroup([$attribute]);
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
