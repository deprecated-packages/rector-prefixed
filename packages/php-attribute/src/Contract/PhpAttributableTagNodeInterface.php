<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PhpAttribute\Contract;

interface PhpAttributableTagNodeInterface
{
    public function getShortName() : string;
    public function getAttributeClassName() : string;
    /**
     * @return mixed[]
     */
    public function getAttributableItems() : array;
}
