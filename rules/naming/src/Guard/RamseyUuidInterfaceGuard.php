<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Guard;

use _PhpScoperb75b35f52b74\Ramsey\Uuid\UuidInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\ValueObject\PropertyRename;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
final class RamseyUuidInterfaceGuard implements \_PhpScoperb75b35f52b74\Rector\Naming\Contract\Guard\ConflictingGuardInterface
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @param PropertyRename $renameValueObject
     */
    public function check(\_PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool
    {
        return $this->nodeTypeResolver->isObjectType($renameValueObject->getProperty(), \_PhpScoperb75b35f52b74\Ramsey\Uuid\UuidInterface::class);
    }
}
