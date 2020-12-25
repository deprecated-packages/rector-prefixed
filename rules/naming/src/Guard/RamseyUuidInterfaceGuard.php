<?php

declare (strict_types=1);
namespace Rector\Naming\Guard;

use _PhpScoper8b9c402c5f32\Ramsey\Uuid\UuidInterface;
use Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use Rector\Naming\Contract\RenameValueObjectInterface;
use Rector\Naming\ValueObject\PropertyRename;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class RamseyUuidInterfaceGuard implements \Rector\Naming\Contract\Guard\ConflictingGuardInterface
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @param PropertyRename $renameValueObject
     */
    public function check(\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool
    {
        return $this->nodeTypeResolver->isObjectType($renameValueObject->getProperty(), \_PhpScoper8b9c402c5f32\Ramsey\Uuid\UuidInterface::class);
    }
}
