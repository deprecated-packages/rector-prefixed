<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\Tests\Rector\Foreach_\ForeachItemsAssignToEmptyArrayToAssignRector\Source;

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
