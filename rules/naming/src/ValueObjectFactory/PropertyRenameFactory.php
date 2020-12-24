<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\ValueObjectFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Naming\Contract\ExpectedNameResolver\ExpectedNameResolverInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\ValueObject\PropertyRename;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @see \Rector\Naming\Tests\ValueObjectFactory\PropertyRenameFactory\PropertyRenameFactoryTest
 */
final class PropertyRenameFactory
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function create(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property, \_PhpScoperb75b35f52b74\Rector\Naming\Contract\ExpectedNameResolver\ExpectedNameResolverInterface $expectedNameResolver) : ?\_PhpScoperb75b35f52b74\Rector\Naming\ValueObject\PropertyRename
    {
        if (\count((array) $property->props) !== 1) {
            return null;
        }
        $expectedName = $expectedNameResolver->resolveIfNotYet($property);
        if ($expectedName === null) {
            return null;
        }
        $currentName = $this->nodeNameResolver->getName($property);
        $propertyClassLike = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($propertyClassLike === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException("There shouldn't be a property without AttributeKey::CLASS_NODE");
        }
        $propertyClassLikeName = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($propertyClassLikeName === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException("There shouldn't be a property without AttributeKey::CLASS_NAME");
        }
        return new \_PhpScoperb75b35f52b74\Rector\Naming\ValueObject\PropertyRename($property, $expectedName, $currentName, $propertyClassLike, $propertyClassLikeName, $property->props[0]);
    }
}
