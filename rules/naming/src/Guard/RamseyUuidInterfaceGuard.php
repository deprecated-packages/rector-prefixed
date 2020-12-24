<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\Guard;

use _PhpScoper2a4e7ab1ecbc\Ramsey\Uuid\UuidInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\ValueObject\PropertyRename;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver;
final class RamseyUuidInterfaceGuard implements \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\Guard\ConflictingGuardInterface
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @param PropertyRename $renameValueObject
     */
    public function check(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool
    {
        return $this->nodeTypeResolver->isObjectType($renameValueObject->getProperty(), \_PhpScoper2a4e7ab1ecbc\Ramsey\Uuid\UuidInterface::class);
    }
}
