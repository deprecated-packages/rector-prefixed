<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\Doctrine;

interface InversedByNodeInterface
{
    public function getInversedBy() : ?string;
    public function removeInversedBy() : void;
}
