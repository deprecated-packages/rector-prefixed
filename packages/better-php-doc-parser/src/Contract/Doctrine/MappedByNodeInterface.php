<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine;

interface MappedByNodeInterface
{
    public function getMappedBy() : ?string;
    public function removeMappedBy() : void;
}
