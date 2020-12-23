<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\Tests\Rector\Foreach_\ForeachItemsAssignToEmptyArrayToAssignRector\Source;

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
