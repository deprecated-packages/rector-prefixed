<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Restoration\NameMatcher;

use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\NullableType;
use _PhpScoperb75b35f52b74\PhpParser\Node\UnionType;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\Restoration\NameMatcher\NameMatcher $nameMatcher)
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
        if ($name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\NullableType) {
            $fullyQulifiedNullableType = $this->matchFullyQualifiedName($name->type);
            if (!$fullyQulifiedNullableType instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
                return null;
            }
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\NullableType($fullyQulifiedNullableType);
        }
        if ($name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            if (\count((array) $name->parts) !== 1) {
                return null;
            }
            $resolvedName = $this->nodeNameResolver->getName($name);
            if (\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($resolvedName)) {
                return null;
            }
            $fullyQualified = $this->nameMatcher->makeNameFullyQualified($resolvedName);
            if ($fullyQualified === null) {
                return null;
            }
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($fullyQualified);
        }
        return null;
    }
}
