<?php

declare(strict_types=1);

namespace Rector\Naming\RenameGuard;

use Rector\Naming\Contract\Guard\ConflictingNameGuardInterface;
use Rector\Naming\Contract\RenameValueObjectInterface;

final class PropertyRenameGuard
{
    /**
     * @var ConflictingNameGuardInterface[]
     */
    private $conflictingNameGuards = [];

    /**
     * @param ConflictingNameGuardInterface[] $conflictingNameGuards
     */
    public function __construct(array $conflictingNameGuards)
    {
        $this->conflictingNameGuards = $conflictingNameGuards;
    }

    public function shouldSkip(RenameValueObjectInterface $renameValueObject): bool
    {
        foreach ($this->conflictingNameGuards as $conflictingNameGuard) {
            if ($conflictingNameGuard->isConflicting($renameValueObject)) {
                return true;
            }
        }

        return false;
    }
}
