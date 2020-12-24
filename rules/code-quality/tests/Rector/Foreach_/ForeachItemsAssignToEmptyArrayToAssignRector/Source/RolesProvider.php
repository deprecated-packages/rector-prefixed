<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Tests\Rector\Foreach_\ForeachItemsAssignToEmptyArrayToAssignRector\Source;

final class RolesProvider
{
    /**
     * @return string[]
     */
    public function getRoles() : array
    {
        return ['play', 'role'];
    }
}
