<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Contract;

interface RenameValueObjectInterface
{
    public function getCurrentName() : string;
    public function getExpectedName() : string;
}
