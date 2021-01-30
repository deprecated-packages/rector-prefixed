<?php

declare (strict_types=1);
namespace Rector\PhpAttribute\Printer;

use PhpParser\BuilderHelpers;
use PhpParser\Node\Arg;
use PhpParser\Node\Attribute;
use PhpParser\Node\AttributeGroup;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use Rector\PhpAttribute\Contract\ManyPhpAttributableTagNodeInterface;
use Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
final class PhpAttributeGroupFactory
{
    /**
     * A dummy placeholder for annotation, that we know will be converted to attributes,
     * but don't have specific attribute class yet.
     *
     * @var string
     */
    public const TO_BE_ANNOUNCED = 'TBA';
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
    public function printItemsToAttributeArgs(\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface $phpAttributableTagNode) : array
    {
        $items = $phpAttributableTagNode->getAttributableItems();
        return $this->createArgsFromItems($items);
    }
    /**
     * @return AttributeGroup[]
     */
    private function printPhpAttributableTagNode(\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface $phpAttributableTagNode) : array
    {
        $args = $this->printItemsToAttributeArgs($phpAttributableTagNode);
        $attributeClassName = $this->resolveAttributeClassName($phpAttributableTagNode);
        $attributeGroups = [];
        $attributeGroups[] = $this->createAttributeGroupFromNameAndArgs($attributeClassName, $args);
        if ($phpAttributableTagNode instanceof \Rector\PhpAttribute\Contract\ManyPhpAttributableTagNodeInterface) {
            foreach ($phpAttributableTagNode->provide() as $shortName => $items) {
                $args = $this->createArgsFromItems($items);
                $name = new \PhpParser\Node\Name($shortName);
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
            $silentValue = \PhpParser\BuilderHelpers::normalizeValue($items[$silentKey]);
            $args[] = new \PhpParser\Node\Arg($silentValue);
            unset($items[$silentKey]);
        }
        if ($this->isArrayArguments($items)) {
            foreach ($items as $key => $value) {
                $argumentName = new \PhpParser\Node\Identifier($key);
                $value = \PhpParser\BuilderHelpers::normalizeValue($value);
                $args[] = new \PhpParser\Node\Arg($value, \false, \false, [], $argumentName);
            }
        } else {
            foreach ($items as $value) {
                $value = \PhpParser\BuilderHelpers::normalizeValue($value);
                $args[] = new \PhpParser\Node\Arg($value);
            }
        }
        return $args;
    }
    private function resolveAttributeClassName(\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface $phpAttributableTagNode) : \PhpParser\Node\Name
    {
        if ($phpAttributableTagNode->getAttributeClassName() !== self::TO_BE_ANNOUNCED) {
            return new \PhpParser\Node\Name\FullyQualified($phpAttributableTagNode->getAttributeClassName());
        }
        return new \PhpParser\Node\Name($phpAttributableTagNode->getShortName());
    }
    /**
     * @param Arg[] $args
     */
    private function createAttributeGroupFromNameAndArgs(\PhpParser\Node\Name $name, array $args) : \PhpParser\Node\AttributeGroup
    {
        $attribute = new \PhpParser\Node\Attribute($name, $args);
        return new \PhpParser\Node\AttributeGroup([$attribute]);
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
