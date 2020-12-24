<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine;

interface MappedByNodeInterface
{
    public function getMappedBy() : ?string;
    public function removeMappedBy() : void;
}
