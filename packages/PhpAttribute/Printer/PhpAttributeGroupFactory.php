<?php

declare (strict_types=1);
namespace Rector\PhpAttribute\Printer;

use PhpParser\BuilderHelpers;
use PhpParser\Node\Arg;
use PhpParser\Node\Attribute;
use PhpParser\Node\AttributeGroup;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode;
use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantFloatType;
use Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode;
use Rector\Php80\ValueObject\AnnotationToAttribute;
final class PhpAttributeGroupFactory
{
    public function createFromSimpleTag(\Rector\Php80\ValueObject\AnnotationToAttribute $annotationToAttribute) : \PhpParser\Node\AttributeGroup
    {
        $fullyQualified = new \PhpParser\Node\Name\FullyQualified($annotationToAttribute->getAttributeClass());
        $attribute = new \PhpParser\Node\Attribute($fullyQualified);
        return new \PhpParser\Node\AttributeGroup([$attribute]);
    }
    public function create(\Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode $doctrineAnnotationTagValueNode, \Rector\Php80\ValueObject\AnnotationToAttribute $annotationToAttribute) : \PhpParser\Node\AttributeGroup
    {
        $fullyQualified = new \PhpParser\Node\Name\FullyQualified($annotationToAttribute->getAttributeClass());
        $values = $doctrineAnnotationTagValueNode->getValuesWithExplicitSilentAndWithoutQuotes();
        $args = $this->createArgsFromItems($values);
        $attribute = new \PhpParser\Node\Attribute($fullyQualified, $args);
        return new \PhpParser\Node\AttributeGroup([$attribute]);
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
                $value = $this->normalizeNodeValue($value);
                $value = \PhpParser\BuilderHelpers::normalizeValue($value);
                $args[] = new \PhpParser\Node\Arg($value, \false, \false, [], $argumentName);
            }
        } else {
            foreach ($items as $item) {
                $item = \PhpParser\BuilderHelpers::normalizeValue($item);
                $args[] = new \PhpParser\Node\Arg($item);
            }
        }
        return $args;
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
    /**
     * @param mixed $value
     * @return bool|float|int|string
     */
    private function normalizeNodeValue($value)
    {
        if ($value instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode) {
            return (int) $value->value;
        }
        if ($value instanceof \PHPStan\Type\Constant\ConstantFloatType) {
            return $value->getValue();
        }
        if ($value instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
            return $value->getValue();
        }
        if ($value instanceof \PHPStan\PhpDocParser\Ast\Node) {
            return (string) $value;
        }
        return $value;
    }
}
