<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Guard;

use _PhpScopere8e811afab72\Ramsey\Uuid\UuidInterface;
use _PhpScopere8e811afab72\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScopere8e811afab72\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScopere8e811afab72\Rector\Naming\ValueObject\PropertyRename;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class RamseyUuidInterfaceGuard implements \_PhpScopere8e811afab72\Rector\Naming\Contract\Guard\ConflictingGuardInterface
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @param PropertyRename $renameValueObject
     */
    public function check(\_PhpScopere8e811afab72\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool
    {
        return $this->nodeTypeResolver->isObjectType($renameValueObject->getProperty(), \_PhpScopere8e811afab72\Ramsey\Uuid\UuidInterface::class);
    }
}
