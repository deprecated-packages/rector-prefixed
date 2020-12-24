<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract;

interface GenericPhpDocNodeFactoryInterface extends \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface
{
    /**
     * @return string[]
     */
    public function getTagValueNodeClassesToAnnotationClasses() : array;
}
