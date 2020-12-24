<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\NameTypeResolver\NameTypeResolverTest
 */
final class NameTypeResolver implements \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Name::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified::class];
    }
    /**
     * @param Name $node
     */
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($node->toString() === 'parent') {
            return $this->resolveParent($node);
        }
        $fullyQualifiedName = $this->resolveFullyQualifiedName($node);
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($fullyQualifiedName);
    }
    /**
     * @return ObjectType|UnionType|MixedType
     */
    private function resolveParent(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $name) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        /** @var string|null $parentClassName */
        $parentClassName = $name->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        // missing parent class, probably unused parent:: call
        if ($parentClassName === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        $type = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($parentClassName);
        $parentParentClass = \get_parent_class($parentClassName);
        if ($parentParentClass) {
            $type = new \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType([$type, new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($parentParentClass)]);
        }
        return $type;
    }
    private function resolveFullyQualifiedName(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $name) : string
    {
        $nameValue = $name->toString();
        if (\in_array($nameValue, ['self', 'static', 'this'], \true)) {
            /** @var string|null $class */
            $class = $name->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if ($class === null) {
                // anonymous class probably
                return 'Anonymous';
            }
            return $class;
        }
        /** @var Name|null $resolvedNameNode */
        $resolvedNameNode = $name->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME);
        if ($resolvedNameNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            return $resolvedNameNode->toString();
        }
        return $nameValue;
    }
}
