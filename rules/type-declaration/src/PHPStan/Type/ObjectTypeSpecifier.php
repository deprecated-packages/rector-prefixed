<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\PHPStan\Type;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\UseUse;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\AliasedObjectType;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType;
final class ObjectTypeSpecifier
{
    /**
     * @return AliasedObjectType|FullyQualifiedObjectType|ObjectType|MixedType
     */
    public function narrowToFullyQualifiedOrAliasedObjectType(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType $objectType) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        /** @var Use_[]|null $uses */
        $uses = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::USE_NODES);
        if ($uses === null) {
            return $objectType;
        }
        $aliasedObjectType = $this->matchAliasedObjectType($node, $objectType);
        if ($aliasedObjectType !== null) {
            return $aliasedObjectType;
        }
        $shortenedObjectType = $this->matchShortenedObjectType($node, $objectType);
        if ($shortenedObjectType !== null) {
            return $shortenedObjectType;
        }
        $sameNamespacedObjectType = $this->matchSameNamespacedObjectType($node, $objectType);
        if ($sameNamespacedObjectType !== null) {
            return $sameNamespacedObjectType;
        }
        $className = \ltrim($objectType->getClassName(), '\\');
        if (\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($className)) {
            return new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType($className);
        }
        // invalid type
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
    }
    private function matchAliasedObjectType(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType $objectType) : ?\_PhpScoper0a6b37af0871\Rector\PHPStan\Type\AliasedObjectType
    {
        /** @var Use_[]|null $uses */
        $uses = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::USE_NODES);
        if ($uses === null) {
            return null;
        }
        foreach ($uses as $use) {
            foreach ($use->uses as $useUse) {
                if ($useUse->alias === null) {
                    continue;
                }
                $useName = $useUse->name->toString();
                $alias = $useUse->alias->toString();
                $fullyQualifiedName = $useUse->name->toString();
                // A. is alias in use statement matching this class alias
                if ($useUse->alias->toString() === $objectType->getClassName()) {
                    return new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\AliasedObjectType($alias, $fullyQualifiedName);
                }
                // B. is aliased classes matching the class name
                if ($useName === $objectType->getClassName()) {
                    return new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\AliasedObjectType($alias, $fullyQualifiedName);
                }
            }
        }
        return null;
    }
    private function matchShortenedObjectType(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType $objectType) : ?\_PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType
    {
        /** @var Use_[]|null $uses */
        $uses = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::USE_NODES);
        if ($uses === null) {
            return null;
        }
        foreach ($uses as $use) {
            foreach ($use->uses as $useUse) {
                if ($useUse->alias !== null) {
                    continue;
                }
                $partialNamespaceObjectType = $this->matchPartialNamespaceObjectType($objectType, $useUse);
                if ($partialNamespaceObjectType !== null) {
                    return $partialNamespaceObjectType;
                }
                $partialNamespaceObjectType = $this->matchClassWithLastUseImportPart($objectType, $useUse);
                if ($partialNamespaceObjectType instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType) {
                    return $partialNamespaceObjectType->getShortNameType();
                }
                if ($partialNamespaceObjectType instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType) {
                    return $partialNamespaceObjectType;
                }
            }
        }
        return null;
    }
    private function matchSameNamespacedObjectType(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType $objectType) : ?\_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType
    {
        $namespaceName = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NAME);
        if ($namespaceName === null) {
            return null;
        }
        $namespacedObject = $namespaceName . '\\' . $objectType->getClassName();
        if (\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($namespacedObject)) {
            return new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType($namespacedObject);
        }
        return null;
    }
    private function matchPartialNamespaceObjectType(\_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType $objectType, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\UseUse $useUse) : ?\_PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType
    {
        // partial namespace
        if (!\_PhpScoper0a6b37af0871\Nette\Utils\Strings::startsWith($objectType->getClassName(), $useUse->name->getLast() . '\\')) {
            return null;
        }
        $classNameWithoutLastUsePart = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::after($objectType->getClassName(), '\\', 1);
        $connectedClassName = $useUse->name->toString() . '\\' . $classNameWithoutLastUsePart;
        if (!\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($connectedClassName)) {
            return null;
        }
        if ($objectType->getClassName() === $connectedClassName) {
            return null;
        }
        return new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType($objectType->getClassName(), $connectedClassName);
    }
    /**
     * @return FullyQualifiedObjectType|ShortenedObjectType|null
     */
    private function matchClassWithLastUseImportPart(\_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType $objectType, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\UseUse $useUse) : ?\_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType
    {
        if ($useUse->name->getLast() !== $objectType->getClassName()) {
            return null;
        }
        if (!\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($useUse->name->toString())) {
            return null;
        }
        if ($objectType->getClassName() === $useUse->name->toString()) {
            return new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType($objectType->getClassName());
        }
        return new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType($objectType->getClassName(), $useUse->name->toString());
    }
}
