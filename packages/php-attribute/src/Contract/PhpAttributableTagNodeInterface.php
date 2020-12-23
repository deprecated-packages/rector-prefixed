<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PhpAttribute\Contract;

interface PhpAttributableTagNodeInterface
{
    public function getShortName() : string;
    public function getAttributeClassName() : string;
    /**
     * @return mixed[]
     */
    public function getAttributableItems() : array;
}
