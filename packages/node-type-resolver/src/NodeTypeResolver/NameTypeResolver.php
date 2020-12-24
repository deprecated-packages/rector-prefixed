<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\NameTypeResolver\NameTypeResolverTest
 */
final class NameTypeResolver implements \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Name::class, \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified::class];
    }
    /**
     * @param Name $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($node->toString() === 'parent') {
            return $this->resolveParent($node);
        }
        $fullyQualifiedName = $this->resolveFullyQualifiedName($node);
        return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($fullyQualifiedName);
    }
    /**
     * @return ObjectType|UnionType|MixedType
     */
    private function resolveParent(\_PhpScopere8e811afab72\PhpParser\Node\Name $name) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        /** @var string|null $parentClassName */
        $parentClassName = $name->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        // missing parent class, probably unused parent:: call
        if ($parentClassName === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $type = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($parentClassName);
        $parentParentClass = \get_parent_class($parentClassName);
        if ($parentParentClass) {
            $type = new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([$type, new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($parentParentClass)]);
        }
        return $type;
    }
    private function resolveFullyQualifiedName(\_PhpScopere8e811afab72\PhpParser\Node\Name $name) : string
    {
        $nameValue = $name->toString();
        if (\in_array($nameValue, ['self', 'static', 'this'], \true)) {
            /** @var string|null $class */
            $class = $name->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if ($class === null) {
                // anonymous class probably
                return 'Anonymous';
            }
            return $class;
        }
        /** @var Name|null $resolvedNameNode */
        $resolvedNameNode = $name->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME);
        if ($resolvedNameNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            return $resolvedNameNode->toString();
        }
        return $nameValue;
    }
}
