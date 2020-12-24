<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PhpAttribute\Contract;

interface PhpAttributableTagNodeInterface
{
    public function getShortName() : string;
    public function getAttributeClassName() : string;
    /**
     * @return mixed[]
     */
    public function getAttributableItems() : array;
}
