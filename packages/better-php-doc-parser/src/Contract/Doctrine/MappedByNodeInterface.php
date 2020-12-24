<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine;

interface MappedByNodeInterface
{
    public function getMappedBy() : ?string;
    public function removeMappedBy() : void;
}
