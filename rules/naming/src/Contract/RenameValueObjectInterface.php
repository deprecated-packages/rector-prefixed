<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Contract;

interface RenameValueObjectInterface
{
    public function getCurrentName() : string;
    public function getExpectedName() : string;
}
