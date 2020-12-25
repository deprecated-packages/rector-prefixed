<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\NodeTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\NameTypeResolver\NameTypeResolverTest
 */
final class NameTypeResolver implements \Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\PhpParser\Node\Name::class, \PhpParser\Node\Name\FullyQualified::class];
    }
    /**
     * @param Name $node
     */
    public function resolve(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        if ($node->toString() === 'parent') {
            return $this->resolveParent($node);
        }
        $fullyQualifiedName = $this->resolveFullyQualifiedName($node);
        return new \PHPStan\Type\ObjectType($fullyQualifiedName);
    }
    /**
     * @return ObjectType|UnionType|MixedType
     */
    private function resolveParent(\PhpParser\Node\Name $name) : \PHPStan\Type\Type
    {
        /** @var string|null $parentClassName */
        $parentClassName = $name->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        // missing parent class, probably unused parent:: call
        if ($parentClassName === null) {
            return new \PHPStan\Type\MixedType();
        }
        $type = new \PHPStan\Type\ObjectType($parentClassName);
        $parentParentClass = \get_parent_class($parentClassName);
        if ($parentParentClass) {
            $type = new \PHPStan\Type\UnionType([$type, new \PHPStan\Type\ObjectType($parentParentClass)]);
        }
        return $type;
    }
    private function resolveFullyQualifiedName(\PhpParser\Node\Name $name) : string
    {
        $nameValue = $name->toString();
        if (\in_array($nameValue, ['self', 'static', 'this'], \true)) {
            /** @var string|null $class */
            $class = $name->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if ($class === null) {
                // anonymous class probably
                return 'Anonymous';
            }
            return $class;
        }
        /** @var Name|null $resolvedNameNode */
        $resolvedNameNode = $name->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME);
        if ($resolvedNameNode instanceof \PhpParser\Node\Name) {
            return $resolvedNameNode->toString();
        }
        return $nameValue;
    }
}
