<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\ValueObjectFactory;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Naming\Contract\ExpectedNameResolver\ExpectedNameResolverInterface;
use _PhpScoper0a2ac50786fa\Rector\Naming\ValueObject\PropertyRename;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @see \Rector\Naming\Tests\ValueObjectFactory\PropertyRenameFactory\PropertyRenameFactoryTest
 */
final class PropertyRenameFactory
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function create(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property, \_PhpScoper0a2ac50786fa\Rector\Naming\Contract\ExpectedNameResolver\ExpectedNameResolverInterface $expectedNameResolver) : ?\_PhpScoper0a2ac50786fa\Rector\Naming\ValueObject\PropertyRename
    {
        if (\count((array) $property->props) !== 1) {
            return null;
        }
        $expectedName = $expectedNameResolver->resolveIfNotYet($property);
        if ($expectedName === null) {
            return null;
        }
        $currentName = $this->nodeNameResolver->getName($property);
        $propertyClassLike = $property->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($propertyClassLike === null) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException("There shouldn't be a property without AttributeKey::CLASS_NODE");
        }
        $propertyClassLikeName = $property->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($propertyClassLikeName === null) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException("There shouldn't be a property without AttributeKey::CLASS_NAME");
        }
        return new \_PhpScoper0a2ac50786fa\Rector\Naming\ValueObject\PropertyRename($property, $expectedName, $currentName, $propertyClassLike, $propertyClassLikeName, $property->props[0]);
    }
}
