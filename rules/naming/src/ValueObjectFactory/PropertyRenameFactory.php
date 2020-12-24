<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\ValueObjectFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Naming\Contract\ExpectedNameResolver\ExpectedNameResolverInterface;
use _PhpScopere8e811afab72\Rector\Naming\ValueObject\PropertyRename;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @see \Rector\Naming\Tests\ValueObjectFactory\PropertyRenameFactory\PropertyRenameFactoryTest
 */
final class PropertyRenameFactory
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function create(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property, \_PhpScopere8e811afab72\Rector\Naming\Contract\ExpectedNameResolver\ExpectedNameResolverInterface $expectedNameResolver) : ?\_PhpScopere8e811afab72\Rector\Naming\ValueObject\PropertyRename
    {
        if (\count((array) $property->props) !== 1) {
            return null;
        }
        $expectedName = $expectedNameResolver->resolveIfNotYet($property);
        if ($expectedName === null) {
            return null;
        }
        $currentName = $this->nodeNameResolver->getName($property);
        $propertyClassLike = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($propertyClassLike === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException("There shouldn't be a property without AttributeKey::CLASS_NODE");
        }
        $propertyClassLikeName = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($propertyClassLikeName === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException("There shouldn't be a property without AttributeKey::CLASS_NAME");
        }
        return new \_PhpScopere8e811afab72\Rector\Naming\ValueObject\PropertyRename($property, $expectedName, $currentName, $propertyClassLike, $propertyClassLikeName, $property->props[0]);
    }
}
