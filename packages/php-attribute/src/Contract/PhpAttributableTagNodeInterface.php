<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PhpAttribute\Contract;

interface PhpAttributableTagNodeInterface
{
    public function getShortName() : string;
    public function getAttributeClassName() : string;
    /**
     * @return mixed[]
     */
    public function getAttributableItems() : array;
}
