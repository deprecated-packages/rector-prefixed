<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract;

interface RenameValueObjectInterface
{
    public function getCurrentName() : string;
    public function getExpectedName() : string;
}
