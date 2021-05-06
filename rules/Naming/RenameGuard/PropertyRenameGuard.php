<?php

declare (strict_types=1);
namespace Rector\Naming\RenameGuard;

use Rector\Naming\Contract\Guard\ConflictingNameGuardInterface;
use Rector\Naming\Contract\RenameValueObjectInterface;
final class PropertyRenameGuard
{
    /**
     * @var mixed[]
     */
    private $conflictingNameGuards;
    /**
     * @param ConflictingNameGuardInterface[] $conflictingNameGuards
     */
    public function __construct(
        /**
         * @var ConflictingNameGuardInterface[]
         */
        array $conflictingNameGuards
    )
    {
        $this->conflictingNameGuards = $conflictingNameGuards;
    }
    public function shouldSkip(\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool
    {
        foreach ($this->conflictingNameGuards as $conflictingNameGuard) {
            if ($conflictingNameGuard->isConflicting($renameValueObject)) {
                return \true;
            }
        }
        return \false;
    }
}
