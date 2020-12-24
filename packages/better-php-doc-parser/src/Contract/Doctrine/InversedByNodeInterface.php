<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine;

interface InversedByNodeInterface
{
    public function getInversedBy() : ?string;
    public function removeInversedBy() : void;
}
