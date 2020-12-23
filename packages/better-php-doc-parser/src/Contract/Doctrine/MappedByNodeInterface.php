<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\Doctrine;

interface MappedByNodeInterface
{
    public function getMappedBy() : ?string;
    public function removeMappedBy() : void;
}
