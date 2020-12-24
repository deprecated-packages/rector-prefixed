<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Guard;

use _PhpScoper0a6b37af0871\Ramsey\Uuid\UuidInterface;
use _PhpScoper0a6b37af0871\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScoper0a6b37af0871\Rector\Naming\ValueObject\PropertyRename;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
final class RamseyUuidInterfaceGuard implements \_PhpScoper0a6b37af0871\Rector\Naming\Contract\Guard\ConflictingGuardInterface
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @param PropertyRename $renameValueObject
     */
    public function check(\_PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool
    {
        return $this->nodeTypeResolver->isObjectType($renameValueObject->getProperty(), \_PhpScoper0a6b37af0871\Ramsey\Uuid\UuidInterface::class);
    }
}
