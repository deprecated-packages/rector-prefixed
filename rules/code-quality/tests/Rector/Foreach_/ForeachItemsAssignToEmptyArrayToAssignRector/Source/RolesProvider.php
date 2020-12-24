<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Tests\Rector\Foreach_\ForeachItemsAssignToEmptyArrayToAssignRector\Source;

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
