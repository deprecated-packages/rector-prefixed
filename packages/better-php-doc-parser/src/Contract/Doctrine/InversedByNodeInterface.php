<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine;

interface InversedByNodeInterface
{
    public function getInversedBy() : ?string;
    public function removeInversedBy() : void;
}
