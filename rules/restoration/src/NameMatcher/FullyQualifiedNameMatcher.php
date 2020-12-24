<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Restoration\NameMatcher;

use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PhpParser\Node\NullableType;
use _PhpScoper0a6b37af0871\PhpParser\Node\UnionType;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
final class FullyQualifiedNameMatcher
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NameMatcher
     */
    private $nameMatcher;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\Restoration\NameMatcher\NameMatcher $nameMatcher)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nameMatcher = $nameMatcher;
    }
    /**
     * @param string|Name|Identifier|FullyQualified|UnionType|NullableType|null $name
     * @return NullableType|FullyQualified|null
     */
    public function matchFullyQualifiedName($name)
    {
        if ($name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\NullableType) {
            $fullyQulifiedNullableType = $this->matchFullyQualifiedName($name->type);
            if (!$fullyQulifiedNullableType instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
                return null;
            }
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\NullableType($fullyQulifiedNullableType);
        }
        if ($name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
            if (\count((array) $name->parts) !== 1) {
                return null;
            }
            $resolvedName = $this->nodeNameResolver->getName($name);
            if (\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($resolvedName)) {
                return null;
            }
            $fullyQualified = $this->nameMatcher->makeNameFullyQualified($resolvedName);
            if ($fullyQualified === null) {
                return null;
            }
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified($fullyQualified);
        }
        return null;
    }
}
