<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine;

interface InversedByNodeInterface
{
    public function getInversedBy() : ?string;
    public function removeInversedBy() : void;
}
